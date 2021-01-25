<?php

namespace backend\controllers;

use Yii;
use Throwable;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use common\models\User;
use yii\db\ActiveQuery;
use common\models\Forms;
use yii\data\Pagination;
use common\models\SpBoost;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Department;
use yii\filters\AccessControl;
use common\components\SesMailer;
use common\models\PropertyPrint;
use yii\db\StaleObjectException;
use common\models\PropertyDetails;
use yii\web\NotFoundHttpException;
use common\components\WebmeglerApiHelper;
use backend\controllers\actions\OppdragDataTableAction;
use backend\controllers\actions\OppdragPrintTableAction;
use backend\controllers\actions\OppdragPrintNextTableAction;
use backend\controllers\actions\InteressenterDataTableAction;

/**
 * Oppdrag controller
 */
class OppdragController extends RoleController
{
    private $office = false;
    private $partner = false;
    private $filterUserUrl = false;

    public function init()
    {
        $this->office = Yii::$app->request->get('office', false);
        $this->partner = Yii::$app->request->get('partner', false);
        $this->filterUserUrl = Yii::$app->request->get('user', false);

        Yii::$app->view->params['oppdrag'] = 'active';

        parent::init();
    }

    public function beforeAction($action)
    {
        if ($action->id == 'printstatus') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => 'yii\web\ErrorAction',
            'data-table' => OppdragDataTableAction::class,
            'interessenter-data-table' => InteressenterDataTableAction::class,
            'print-table' => OppdragPrintTableAction::class,
            'print-next-table' => OppdragPrintNextTableAction::class,
        ];
    }

    /**
     * Show list resources from storage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->view->title = 'Oppdrag';

        $departments = Department::find()
            ->with(['users'])
            ->where(['inaktiv' => 0])
            ->cache()
            ->all();

        return $this->render('index', [
            'user' => $this->filterUserUrl,
            'office' => $this->office,
            'partner' => $this->partner,
            'departments' => $departments
        ]);
    }

    /**
     * Show list resources from storage.
     *
     * @return string
     */
    public function actionBefaring()
    {
        $this->view->title = 'Oppdrag Befaring';

        $departments = Department::find()
            ->with(['users'])
            ->where(['inaktiv' => 0])
            ->cache()
            ->all();

        return $this->render('inspection', [
            'user' => $this->filterUserUrl,
            'office' => $this->office,
            'partner' => $this->partner,
            'departments' => $departments,
            'type' => 'befaring'
        ]);
    }

    /**
     * Display a listing of the leads.
     *
     * @param $id
     *
     * @return string
     */
    public function actionInteressenter($id)
    {
        $this->layout = 'oppdrag_layout';
        $this->view->params['v'] = 'interessenter';

        $this->view->params['model'] = $property = PropertyDetails::find()
            ->joinWith(['user.department'])
            ->where(['property_details.id' => $id])
            ->one();

        $formTypes = Forms::find()
            ->where(['target_id' => $id])
            ->select('type')
            ->groupBy('type')
            ->all();

        $formTypes = array_column($formTypes, 'type');

        return $this->render('interessenter', compact('property', 'formTypes', 'id'));
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetaljer($id)
    {
        $this->layout = 'oppdrag_layout';

        /** @var User $user */
        $user = Yii::$app->user->identity;

        $model = PropertyDetails::find()
            ->joinWith([
                'propertyImage',
                'propertyNeighbourhoods',
                'user.department'
            ])
            ->with(['parent', 'properties'])
            ->where(['property_details.id' => $id]);

        if ($this->office && !$user->hasRole('superadmin')) {
            if ($user->url === $this->office) {
                $model->andWhere([
                    'property_details.ansatte1_id' => $user->web_id
                ]);
            } else {
                $model->andWhere([
                    'department.url' => $this->office
                ]);
            }
        }

        if (!$model = $model->one()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->view->params['model'] = $model;
        $this->view->params['v'] = 'detaljer';

        $partner_id = $model->partner->id;

        $sp_boosts = Json::encode(ArrayHelper::map(SpBoost::find()
            ->select(["name as key", "CONCAT(name, ' (', price, ')') as value"])
            ->andWhere(["or",
                ["partner_ids" => $partner_id],
                ["like", "partner_ids", "%,{$partner_id},%", false],
                ["like", "partner_ids", "{$partner_id},%", false],
                ["like", "partner_ids", "%,{$partner_id}", false]
            ])
            ->asArray()->all(), "key", "value"));

        return $this->render('detaljer', compact('model', 'sp_boosts'));
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFremdrift($id)
    {
        $this->layout = 'oppdrag_layout';
        $model = PropertyDetails::find()->joinWith(['user.department'])
            ->where(['property_details.id' => $id]);

        if ($this->office) {
            $model = $this->office == Yii::$app->user->identity->url
                ? $model->andWhere(['property_details.ansatte1_id' => Yii::$app->user->identity->web_id])
                : $model->andWhere(['department.url' => $this->office]);
        }
        if (!$model = $model->one()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->view->params['model'] = $model;
        $this->view->params['v'] = 'fremdrift';
        return $this->render('fremdrift');
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionStatistikk($id)
    {
        $this->layout = 'oppdrag_layout';

        $model = PropertyDetails::find()
            ->joinWith('propertyAds')->with([
                    'digitalMarketing' => function (ActiveQuery $query) {
                        $query->addSelect(['digital_marketing.source_object_id'])
                            ->where(['in', 'digital_marketing.type', ['deltaStandard', 'instagram', 'facebook', 'facebookAB', 'facebookVideo']]);
                        }])
            ->andWhere(['property_details.id' => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->view->params['model'] = $model;
        $this->view->params['v'] = 'statistikk';
        return $this->render('statistikk');
    }


    /**
     * @param $page
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBefaringsmappe($page, $id)
    {
        $this->layout = 'oppdrag_layout';
        $pages = array(
            'dokumenter' => 'befaringsmappe/dokumenter',
            'interessenter' => 'befaringsmappe/interessenter',
            'kalender' => 'befaringsmappe/kalender',
            'omrade' => 'befaringsmappe/omrade',
            'salgsprosessen' => 'befaringsmappe/salgsprosessen',
            'team' => 'befaringsmappe/team',
        );

        $model = PropertyDetails::find()
            ->joinWith(['user.department', 'propertyDocs'])
            ->where(['property_details.id' => $id]);

        if ($this->office) {
            $model = $this->office == Yii::$app->user->identity->url
                ? $model->andWhere(['property_details.ansatte1_id' => Yii::$app->user->identity->web_id])
                : $model->andWhere(['department.url' => $this->office]);
        }
        if (!$model = $model->one()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->view->params['model'] = $model;

        $view = isset($pages[$page]) ? $page : 'dokumenter';
        $this->view->params['v'] = 'befaringsmappe';
        $this->view->params['v2'] = $view;
        return $this->render($pages[$view], compact('model'));
    }

    public function actionPrint()
    {
        return $this->renderPartial('print');
    }

    public function actionPrintNext()
    {
        return $this->renderPartial('print_next');
    }

    public function actionPrintStore()
    {
        response()->format = Response::FORMAT_JSON;

        $property = PropertyPrint::findOne([
            'property_id' => request()->post('property_id')
        ]) ?? new PropertyPrint;

        if ($property->isNewRecord) {
            foreach (request()->post() as $column => $value) {
                $property->$column = $value;
            }

            $property->save(false);
        } else {
            $property->updateAttributes(request()->post());
        }

        return [];
    }

    public function actionPrintstatus($id)
    {
        $property = PropertyDetails::findOne($id);
        $request = Yii::$app->request;

        if ($property && $request->isPost) {
            $property->{$request->post('name')} = $request->post('value') === 'true';
            $property->save(false);
        }
    }


    public function actionDigitalMarketsforing($id)
    {
        $this->layout = 'oppdrag_layout';
        $model = PropertyDetails::find()
            ->with(['digitalMarketing' => function (ActiveQuery $query) {
                $query
                    ->addSelect([
                        'digital_marketing.start',
                        'digital_marketing.stop',
                        'digital_marketing.stats',
                        'digital_marketing.source_object_id',
                        'digital_marketing.type'
                    ])
                    ->where(['in', 'digital_marketing.type', ['deltaStandard', 'instagram', 'facebook', 'facebookAB', 'facebookVideo']]);
            }])
            ->andWhere(['property_details.id' => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $data = [
            'clicks' => 0,
            'impressions' => 0,
            'reach' => 0
        ];
        $dm = [
            'deltaStandard' => $data,
            'instagram' => $data,
            'facebook' => $data,
            'facebookAB' => $data,
            'facebookVideo' => $data,
            'cl_sum' => 0,
            'im_sum' => 0,
            'rc_sum' => 0
        ];

        if (isset($model->digitalMarketing)) {
            $dms = ArrayHelper::toArray($model->digitalMarketing);
            $start_date = $dms[0]['start'];
            $stop_date = $dms[0]['stop'];
            foreach ($dms as $item) {
                $start_date = $start_date < $item['start'] ? $start_date : $item['start'];
                $stop_date = $stop_date > $item['stop'] ? $stop_date : $item['stop'];
                if ($item['stats']) {
                    $arr = json_decode($item['stats'], true);
                    $dm[$item['type']]['clicks'] += $arr['clicks'];
                    $dm[$item['type']]['impressions'] += $arr['impressions'];
                    $dm[$item['type']]['reach'] += $arr['reach'];
                }
            }
            $dm['start'] = date('j. M Y', substr($start_date, 0, 10));
            $dm['stop'] = date('j. M Y.', substr($stop_date, 0, 10));
            $dm['facebook']['clicks'] = $dm['facebook']['clicks'] + $dm['facebookAB']['clicks'] + $dm['facebookVideo']['clicks'];
            $dm['facebook']['impressions'] = $dm['facebook']['impressions'] + $dm['facebookAB']['impressions'] + $dm['facebookVideo']['impressions'];
            $dm['facebook']['reach'] = $dm['facebook']['reach'] + $dm['facebookAB']['reach'] + $dm['facebookVideo']['reach'];
            $dm['cl_sum'] = $dm['deltaStandard']['clicks'] + $dm['instagram']['clicks'] + $dm['facebook']['clicks'];
            $dm['im_sum'] = $dm['deltaStandard']['impressions'] + $dm['instagram']['impressions'] + $dm['facebook']['impressions'];
            $dm['rc_sum'] = $dm['deltaStandard']['reach'] + $dm['instagram']['reach'] + $dm['facebook']['reach'];
        }

        $this->view->params['model'] = $model;
        $this->view->params['v'] = 'statistikk';

        $dm_soc = [
            ['key' => 'facebook', 'title' => 'Facebook', 'class' => 'socicon-facebook', 'tag' => 'td'],
            ['key' => 'instagram', 'title' => 'Instagram', 'class' => 'socicon-instagram', 'tag' => 'td'],
            ['key' => 'deltaStandard', 'title' => 'Programmatisk', 'class' => 'socicon-btn socicon-google', 'tag' => 'th']
        ];
        foreach ($dm_soc as $key => $item) {
            if ($dm[$item['key']] != $data) $dm_soc[$key] += $dm[$item['key']];
            else unset($dm_soc[$key]);

            unset($dm[$item['key']]);
        }

        return $this->render('digital-marketsforing', compact('model', 'dm', 'dm_soc'));
    }

    /**
     * Send email for more adds.
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionMoreadds($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $boostType = Yii::$app->request->get("boostType");
        $oppdrag = PropertyDetails::findOne(['id' => $id]);
        $mailer = new SesMailer;
        $user = Yii::$app->user->identity;
        $toEmail_1 = 'hanne@involve.no';
        $toEmail_2 = 'morten@involve.no';
        $sender = 'Partners.no <post@partners.no>';

        if ($boostType) {
            $json = json_decode($oppdrag->sp_boost, true) ?? [];
            if (!array_key_exists($boostType, $json)) $json[$boostType] = 0;
            ksort($json);
            $json[$boostType] += 1;
            $oppdrag->sp_boost = json_encode($json);
        }
        $body = $this->renderPartial("more-adds-email", [
            'oppdrag' => $oppdrag,
            'broker' => $user,
            'backend_link' => Url::toRoute(['detaljer', 'id' => $id], true),
            'frontend_link' => Yii::$app->request->hostInfo . "/eiendommer/{$oppdrag->oppdragsnummer}",
        ]);

        file_put_contents('email_debugg.php', "\n {$oppdrag->id}:{$oppdrag->adresse}\n {$body}", FILE_APPEND);
        $subject = 'Ad Boost';
        // Add sender as broker
        // $sender = "{$user->navn} <{$user->email}>";
        $response = $mailer->sendMail($body, $subject, [$toEmail_1, $toEmail_2, $user->email], $sender);

        if ($mailer->fails()) {
            Yii::error($response);
        }

        $oppdrag->update(false);

        return Json::encode([
            'success' => true,
            'message' => 'Din melding er sendt til markedsavdelingen.',
            'pd_boost' => json_decode($oppdrag->sp_boost, true)
        ]);
    }

    /**
     * Update Client
     * Updates client from request params
     * @param bool|integer $id
     * @return string|HTML
     */
    public function actionSetShowHide($id = false)
    {
        $prop = false;
        if ($id){
            $prop = PropertyDetails::findOne(['id'=>$id]);
            if($prop->load(Yii::$app->request->post()) && $prop->validate()){
                // Save if valid
                $prop->save();
            }
        }
        if(!$prop){
            // Create empty models if there is no such model
            $prop = new PropertyDetails();
        }
        return $this->render('_checkbox', [
            'model' => $prop,
        ]);
    }

    /**
     * Update Property From webmegler
     * @param bool|integer $id
     * @return string
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionUpdateProperty($id = false)
    {
        //TODO: add permission control and property get from webmegler
        /** @var WebmeglerApiHelper $api */
        $api = Yii::$app->WebmeglerApiHelper;
        /** @var PropertyDetails $property */
        if (!$property = PropertyDetails::findOne(['id' => $id])) {
            $property = new PropertyDetails;
        } else {
            $api->actionUpdateProperty($id,$property);
        }

        return Json::encode([
            'property' => $property,
            'status' => 'Try reload page.'
        ]);
    }

    /**
     * Update the property_details in storage.
     *
     * @param $id
     *
     * @return string
     */
    public function actionUpdate($id)
    {
        if (!$property = PropertyDetails::findOne($id)) {
            return Json::encode([
                'success' => false,
                'message' => 'Lead not Found'
            ]);
        }

        foreach (Yii::$app->request->post() as $input => $value) {
            $property->{$input} = $value;
        }

        return Json::encode([
            'success' => $property->save(false)
        ]);
    }
}
