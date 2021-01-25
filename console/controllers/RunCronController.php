<?php
namespace console\controllers;
use common\components\SesMailer;
use common\models\Boligvarsling;
use common\models\Department;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\User;
use console\models\Forms;
use fedemotta\cronjob\models\CronJob;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\Json;

/**
 * SomeContrController controller
 */
class RunCronController extends Controller {
    public $delegationLimiter = 50;
    public function options($actionID)
    {
        return ['delegationLimiter'];
    }

    public function optionAliases()
    {
        return [
            'dl' => 'delegationLimiter',
        ];
    }
    /**
     * Run SomeModel::some_method for a period of time
     * @param string $from
     * @param string $to
     * @return int exit code
     */
    public function actionInit($from, $to){
        $dates  = CronJob::getDateRange($from, $to);
        $command = CronJob::run($this->id, $this->action->id, 0, CronJob::countDateRange($dates));
        if ($command === false){
            return ExitCode::UNSPECIFIED_ERROR;
        }else{
            foreach ($dates as $date) {
                //this is the function to execute for each day
                file_put_contents('cron-test.php', date("Y-m-d h:i:s") . " ****** {$date} \n", FILE_APPEND);
            }
            $command->finish();
            return ExitCode::OK;
        }
    }

    /**
     * Run SomeModel::some_method for today only as the default action
     * @return int exit code
     */
    public function actionIndex(){
        return $this->actionInit(date("Y-m-d"), date("Y-m-d"));
    }

    /**
     * Delegate all timeout Leads
     * @return int exit code
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelegateTimeout(){//yii run-cron/delegate-timeout
        echo 'timeout cron';
        $limitPerAction = 10;
        //TODO: optimise queries to select from base nor condition in loop
        $timeoutSize = 60*15;// 15 minutes
        // TODO: ADD status support to forms table
        $leads = Forms::find()
            ->with('delegatedDepartments')
            ->andWhere(['or',
                ['forms.status' => '1001'],
                ['and',
                    ['<','updated_at', time() - $timeoutSize],
                    ['forms.status' => ['1005']]
                ]
            ])->limit($this->delegationLimiter+1)
        ;

        $leads = $leads->all();
        $c = count($leads);
        $serverName = isset(Yii::$app->params['serverName']) ? Yii::$app->params['serverName'] : "{{serverName}}";
        if($c > $this->delegationLimiter){
            $mailer = new SesMailer;
            $m = "Alarm : more than {$this->delegationLimiter} leads({$c}) are waiting for handling on {$serverName}";
            $response = $mailer->sendMail(
                $m,
                'Issue on leads delegation',
                ['alarm@involve.no'],
                'Leads Cron <post@partners.no>'
            );
            if ($mailer->fails()) {
                Yii::error($response);
            }
            self::slackMessage($m);
            return ExitCode::OK;
        }

        if ($c > $this->delegationLimiter/2){
            $mailer = new SesMailer;
            $m = "Alarm : more than " . $this->delegationLimiter/2 . " leads({$c}) are waiting for handling {$serverName}";
            $response = $mailer->sendMail(
                $m,
                'Issue on leads delegation',
                ['alarm@involve.no'],
                'Leads Cron <post@partners.no>'
            );
            if ($mailer->fails()) {
                Yii::error($response);
            }
            self::slackMessage($m);
        }

        /** @var Forms[] $leads */
        for ($i = 0; $i < $limitPerAction; $i++ ) {// Attantion: query in loop
            if(!isset($leads[$i])){break;}
            $lead = $leads[$i];
            /** @var Forms $lead */
            if($lead->justNew()){
                // Still new lead that not delegated to any one
                $lead->attachLead();
                continue;
            }

            if(!Forms::mayLogAndSms() || !($lead->department)){
                $limitPerAction++;
                continue;
            }
            $delDeps = [];

            //TODO: optimise following 2 qeuerys to one
            foreach ($lead->delegatedDepartments as $dep) {
                $delDeps[] = $dep->message;
            }

            $partnerId = $lead->department->partner_id;
            $condidateDeps = Department::find()
                ->where(['not in','short_name',$delDeps])
                ->andWhere([
                    'inaktiv' => 0,
                    'original_id' => null,
                    'partner_id'=>$partnerId,
                ])->all()
            ;

            $c = count($condidateDeps);
            if ( $c > 1 || $c>0 && count($delDeps) ){ // Unallocated Departments left
                $randomDep = $condidateDeps[array_rand($condidateDeps)];
                $lead->allocate($randomDep);
            }else{ // Already Allocated to all departments
                $broker = User::findOne(['web_id' => Partner::findOne(['id'=>$partnerId])->leader_id]);
                $lead->delegate($broker, 'delegert');
            }
        }
        echo "\n Delegated leads: " . count($leads) . "\n";
        return ExitCode::OK;
    }

    /**
     * Outdate forms
     * @return int exit code
     * @throws \yii\db\Exception
     */
    public function actionOutdateForms(){
        $leadTable = Forms::tableName();
        $propTable = PropertyDetails::tableName();
        $coldTypes = "'".implode("','",Forms::getColdTypes())."'";
        $outdateTime =      time() - 60*60*24*2;
        $veryOutdateTime =  time() - 60*60*24*4;

        // outdate brokers
        $q1 = Yii::$app->db->createCommand("
          UPDATE {$leadTable} LEFT JOIN {$propTable}
          ON {$leadTable}.target_id = {$propTable}.id 
          SET 
            broker_id = null, 
            delegated = null
          WHERE 
            handle_type IS NULL 
            AND broker_id IS NOT NULL
            AND {$propTable}.sold_date IS NOT NULL
            AND {$propTable}.sold_date < {$outdateTime}
            AND {$propTable}.solgt = -1
            AND type IN ({$coldTypes})
        ");

        // outdate departments
        $q2 = Yii::$app->db->createCommand("
          UPDATE {$leadTable} LEFT JOIN {$propTable}
          ON {$leadTable}.target_id = {$propTable}.id 
          SET 
            department_id = null, 
            broker_id = null , 
            delegated = null
          WHERE 
            handle_type IS NULL 
            AND department_id IS NOT NULL
            AND {$propTable}.sold_date IS NOT NULL
            AND {$propTable}.sold_date < {$veryOutdateTime}
            AND {$propTable}.solgt = -1
            AND type IN ({$coldTypes})
        ");
        $q2->execute();
        $q1->execute();
        echo "Done\n";
        return ExitCode::OK;
    }

    /**
     * New properties email notifications.
     *
     * @return int
     *
     * @throws \Throwable
     */
    public function actionBoligVarsling()
    {
        $items = Boligvarsling::find()
            ->where(['subscribe' => true])
            ->all();

        $grouped = ArrayHelper::index($items, null, 'email');

        /* @var Boligvarsling[] $subscriptions */
        foreach ($grouped as $email => $subscriptions) {
            $data = [];
            $isFromPartners = false;
            $name = null;

            foreach ($subscriptions as $subscription) {
                $query = PropertyDetails::find()
                    ->select([
                        'property_details.*',
                        'IFNULL(property_details.oppdragsnummer__prosjekthovedoppdrag, property_details.id) as unique_group',
                    ])
                    ->joinWith(['propertyImage']);

                if (!empty($subscription->map_lat) && !empty($subscription->map_lng) && !empty($subscription->map_radius)) {
                    $lat = deg2rad($subscription->map_lat);
                    $lng = deg2rad($subscription->map_lng);
                    $earthR = 6371 * 1000;
                    $query->joinWith(['allPostNumber']);
                    $query->andWhere([
                        '<=',
                        "acos(sin({$lat})*sin(radians(all_post_number.lat))+cos({$lat})*cos(radians(all_post_number.lat))*cos(radians(all_post_number.lon)-{$lng})) * {$earthR}",
                        intval($subscription->map_radius)
                    ]);
                    $query->andWhere(['not', ['property_details.postnummer' => null]]);
                    $query->andWhere(['not', ['all_post_number.id' => null]]);
                } else {
                    if (!empty($subscription->region) && $regions = Json::decode($subscription->region)) {
                        $whereAreas = [];

                        foreach ($regions as $key => $value) {
                            if (is_array($value)) {
                                $value = array_filter($value, function ($item) use ($key) {
                                    return $item !== $key;
                                });

                                $column = ($key === 'Oslo') ? 'kommuneomraade' : 'kommunenavn';

                                if (count($value) < 1) {
                                    $query->orWhere(['and', ['like', 'fylkesnavn', $key]]);
                                } else {
                                    $query->orWhere(['and', [$column => $value]]);
                                }
                            } else {
                                $whereAreas[] = $value;
                            }
                        }

                        if (!empty($whereAreas)) {
                            $query->andWhere(['area' => $whereAreas]);
                        }
                    }
                }

                $query->andWhere(['in', 'finn_eiendomstype', Json::decode($subscription->property_type)]);

                if ($subscription->cost_from && $subscription->cost_to) {
                    $query->andWhere(['between', 'totalkostnadsomtall', $subscription->cost_from, $subscription->cost_to]);
                }

                if ($subscription->area_from && $subscription->area_to) {
                    $query->andWhere(['between', 'prom', $subscription->area_from, $subscription->area_to]);
                }

                if (!empty($subscription->rooms) && $rooms = Json::decode($subscription->rooms)) {
                    if (in_array(5, $rooms)) {
                        $rooms = array_merge($rooms, range(6, 15));
                    }

                    $query->andWhere(['soverom' => $rooms]);
                }

                if (!empty($subscription->criterions) && $criterions = Json::decode($subscription->criterions)) {
                    $query->joinWith(['criterions' => function(ActiveQuery $q) use ($criterions) {
                        $q->where(['criterias.iadnavn' => $criterions]);
                    }]);
                }

                $query->andWhere(['markedsforingsklart' => -1]);
                $query->groupBy(['unique_group']);

                if ($subscription->notify_at) {
                    $query->andWhere(['>', 'markedsforingsdato', $subscription->notify_at]);
                }

                $query->andWhere(['>', 'markedsforingsdato', strtotime($subscription->created_at)]);

                $properties = $query
                    ->andWhere(['solgt' => 0])
                    ->limit(6)
                    ->all();

                $isFromPartners = $subscription->isVipPartner();

                if (!empty($properties)) {
                    $data[] = compact('subscription', 'properties');
                    $name = $subscription->name;
                }
            }

            if (!empty($data)) {
                try {
                    $mailer = new SesMailer;

                    $body = \Yii::$app->controller->renderPartial("@frontend/views/emails/client/boligvarsling_notify",
                        compact('isFromPartners', 'name', 'email', 'data')
                    );

                    $response = $mailer->sendMail($body, 'Boligvarsling', [$email]);

                    if ($mailer->fails()) {
                        \Yii::error($response);

                        $this->stderr(print_r($response));
                    } else {
                        foreach ($data as $val) {
                            $val['subscription']->updateAttributes([
                                'notify_at' => time()
                            ]);
                        }

                        $this->stdout("Send mail to: {$email}" . PHP_EOL);
                    }
                } catch (\Exception $exception) {
                    \Yii::error($exception->getMessage());

                    $this->stderr($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine() . PHP_EOL);
                }
            }
        }

        return ExitCode::OK;
    }

    /**
     * @param $value
     * @return array
     */
    protected function parseRange($value)
    {
        return explode('-', $value);
    }

    /**
     * @param $m
     * @throws \Exception
     * TODO: move all slack interactions to single controller
     */
    static private function slackMessage($m){
        if (
            !Yii::$app->params['slackReport']
            || !($room = Yii::$app->params['slackAlarmRoom'])
            || !Forms::mayLogAndSms()
        ){return;}
        $m .= Yii::$app->params['currentBranch'] ? (" (" . Yii::$app->params['currentBranch'] . ")") : " (NOT Ringeliste)";

        $ch = curl_init($room);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['text' => $m,]),
            CURLOPT_HTTPHEADER => ['Content-type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}