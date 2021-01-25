<?php

namespace backend\controllers;

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use backend\components\UserRating;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use common\components\SesMailer;
use common\components\SnsComponent;
use common\components\StaticMethods;
use common\models\Budsjett;
use common\models\Client;
use common\models\Department;
use common\models\DigitalMarketing;
use common\models\Forms;
use common\models\LoginForm;
use common\models\Mail;
use common\models\News;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\PropertyVisits;
use common\models\Salgssnitt;
use common\models\Sms;
use common\models\Theme;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use function foo\func;

/**
 * Site controller
 */
class SiteController extends RoleController
{
    private $dateRange = false;
    private $office = false;
    private $partner = false;
    private $choosenUser = false;


    /**
     * @var bool|User
     */
    private $user = false;

    public function init()
    {
        parent::init();

        $this->office = Yii::$app->request->get('office');
        $this->partner = Yii::$app->request->get('partner');
        $this->choosenUser = Yii::$app->request->get('user');

        $this->user = Yii::$app->user->identity;

        Yii::$app->view->params['dashboard'] = 'active';
    }

    public function beforeAction($action){
        $this->enableCsrfValidation = false;
        if (!Yii::$app->session->has('date')) {
            Yii::$app->session->set('date', [
                'label' => 'Hittil i år',
                'start' => strtotime('January 1st'),
                'end' => strtotime('December 31st')
            ]);
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
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'forgot-password', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param bool|string $office
     * @param bool|string $user
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($office = false, $user = false){
        $filterUserUrl = $user ? $user : $this->choosenUser;
        $this->office = $this->office ? $this->office : $office;

        if (
            Yii::$app->request->get('start') &&
            Yii::$app->request->get('end')
        ) {
            $this->dateRange = [
                'start' => strtotime(Yii::$app->request->get('start')),
                'end' => strtotime(Yii::$app->request->get('end')),
            ];
        }

        /** Get Leads Block Data*/
        $leadsBlock = $this->getLeadsBlock($this->office, $filterUserUrl);
        
        //TODO : move the following to model
        //$visitsPreviews = $this->getVisitsPreview();

        $properties = $this->getProperties();

        $activeEvents = $this->getActiveEvents(
            Yii::$app->request->get('start'),
            Yii::$app->request->get('end')
        );


        Yii::$app->view->registerJsFile('@web/js/dashboard.js', ['depends' => AppAsset::class]);
        Yii::$app->view->registerCssFile('@web/css/dashboard.css', ['depends' => AppAsset::class]);

        $accordion = $this->getAccordion();

        return $this->render('index', compact(
            'leadsBlock',
            'properties',
            'activeEvents',
            'accordion'
        ));

    }

    /**
     * @return false|string|html
     */
    public function actionBefaring() {
        $this->view->title = 'Befaring';

        Yii::$app->view->params['befaring'] = 'active';
        Yii::$app->view->params['dashboard'] = '';

        if(Yii::$app->request->isAjax) {
            if(!$keyWord = strtolower(Yii::$app->request->post('search'))) {
                return Json::encode([]);
            }

            return Json::encode(StaticMethods::getSearchDataBefaring($keyWord));
        }

        return $this->render('befaring');
    }

    //TODO: add comments to this function and optimise it
    protected function getActiveEvents($fromDate = null, $toDate = null)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $data = [
            'title' => 'HENDELSER',
            'news' => [],
            'clients' => [],
            'properties' => [],
            'visits' => [],
            'partners' => [],
            'departments' => [],
            'count' => 0
        ];
        
        if ($user->hasRole(['superadmin', 'partner']) && !$this->office && !$this->choosenUser) {
            $data['title'] = 'VARSLINGER';

            /** @var Partner[] $partners */
            $partners = Partner::find()
                ->joinWith(['activeDepartments'])
                ->orderBy(['partnerDepartments.short_name' => SORT_ASC])
                ->all();

            $leads = Forms::find()
                ->select(['department_id', 'COUNT(*) as count'])
                ->where(['in', 'type', array_merge(Forms::getHotTypes(), ['book_visning'])])
                ->andWhere(['not', ['department_id' => null]])
                ->andWhere(['not in', 'forms.status', [
                    '1014', '1020', '1017', '1011', '1009', '1013', '1008', '1018', '1016', '1010'
                ]]);

            if ($this->dateRange) {
                $leads->andWhere(['between', 'forms.created_at',
                    $this->dateRange['start'],
                    $this->dateRange['end']
                ]);
            }

            $leads
                ->groupBy('department_id')
                ->indexBy('department_id')
                ->asArray();

            if ($partner = Yii::$app->partnerService->selected()) {
                $leads->joinWith(['department' => function (ActiveQuery $query) use ($partner) {
                    $query->where(['department.partner_id' => $partner->id]);
                }]);

                $leads = $leads->all();

                foreach ($partner->activeDepartments as $department) {
                    $leadsCount = 0;

                    if (isset($leads[$department->web_id])) {
                        $leadsCount = $leads[$department->web_id]['count'];
                    }

                    $data['count'] += $leadsCount;

                    $data['departments'][] = [
                        'url' => UrlExtended::toRouteAddaptive(['clients/paminnelser', 'office' => $department->url]),
                        'name' => $department->short_name,
                        'datetime' => $leadsCount
                    ];
                }

                return $data;
            }

            $leads = $leads->all();

            foreach ($partners as $partner){
                if (empty($partner->activeDepartments)){continue;}
                $data['partners'][$partner->id] = ArrayHelper::toArray($partner);
                $data['partners'][$partner->id]['departments'] = [];
                $data['partners'][$partner->id]['count'] = 0;
                foreach ($partner->activeDepartments as $department) {
                    $leadsCount = 0;

                    if (isset($leads[$department->web_id])) {
                        $leadsCount = $leads[$department->web_id]['count'];
                    }

                    $data['count'] += $leadsCount;

                    $data["partners"][$partner->id]['departments'][] = [
                        'url' => UrlExtended::toRouteAddaptive(['clients/paminnelser', 'office' => $department->url]),
                        'name' => $department->short_name,
                        'datetime' => $leadsCount
                    ];

                    $data['partners'][$partner->id]['count'] += $leadsCount;
                }
            }

            return $data;
        }

        /** @var News[] $news */
        $news = News::find()
            ->joinWith('roles')
            ->where('DATE_ADD( FROM_UNIXTIME( created_at ), INTERVAL 3 DAY ) >= NOW()')
            ->andWhere(['deleted' => 0])
            ->all();

        foreach ($news as $post) {
            $data['news'][] = [
                'badge' => $post->type,
                'url' => UrlExtended::toRoute(['intranett/nyheter-view', 'id' => $post->id]),
                'name' => $post->name,
                'datetime' => date('d.m / H:i', $post->created_at)
            ];
        }

        // Notifications
        $clients = Forms::find()
            ->with('logs')
            ->where(['forms.handle_type' => '1014',])
            ->andWhere(['or',
                ['delegated' => Yii::$app->user->identity->web_id],
                ['broker_id' => Yii::$app->user->identity->web_id]
            ])
            ->andWhere(['not', ['notify_at' => null]])
            ->andWhere(['between', 'notify_at', time(), strtotime('+2 day')])
            ->all();

        if ($this->office) {
            /*$subQuery = (new Query())
                ->select('id')
                ->from('lead_log as l')
                ->where('l.lead_id = forms.id')
                ->andWhere(['in', 'l.type',
                    ['1002', '1006', '1008', '1009', '1010', '1011', '1014', '1016', '1017', '1018', '1013', '1020']
                ]);*/

           $clients += Forms::find()
               ->with(['user.department'])
               ->joinWith(['logs', 'department'])
               ->where(['not',['handle_type' => ['1002', '1006', '1008', '1009', '1010', '1011', '1014', '1016', '1017', '1018', '1013', '1020']]])
               ->andWhere(['department.url' => $this->office])
               ->groupBy('id')
               ->all();
        }

        /** @var Forms[] $clients */
        foreach ($clients as $client) {
            if (count($client->logs) < 1) {
                continue;
            }

            $latestLog = $client->logs[0];

            $dateTime = date('d.m / H:i', $client->notify_at ?? $latestLog->created_at);

            $data['clients'][] = [
                'badge' => $client->handle_type,
                'url' => UrlExtended::toRoute(['clients/detaljer', 'id' => $client->id]),
                'name' => $client->name,
                'body' => $client->message,
                'note' => $client->notify_note,
                'type' => $client->type,
                'datetime' => str_replace(' / 00:00', '', $dateTime),
                'expired' => $latestLog->notify_at ? ($latestLog->notify_at < time()) : false,
                'user_name' => $client->user->navn ?? null,
                'user_department_name' => $client->user->department->short_name ?? null,
                'user_avatar' => $client->user->urlstandardbilde ?? null,
            ];
        }

        $properties = PropertyDetails::find()
            ->joinWith('department')
            ->where(['or',
                'FROM_UNIXTIME(kontraktsmoteinklklokkeslett, "%Y-%m-%d") BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY',
                'FROM_UNIXTIME(overtagelse, "%Y-%m-%d") BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY'
            ]);

        if ($this->choosenUser) {
            $this->choosenUser = User::findOne(['url' => $this->choosenUser]);
            $properties->andWhere(['or',
                ['property_details.ansatte1_id' => $this->choosenUser->web_id],
                ['property_details.ansatte2_id' => $this->choosenUser->web_id]
            ]);
        }

        if ($this->office) {
            $properties->andWhere(['department.url' => $this->office]);
        }

        $properties = $properties->orderBy([
            'overtagelse' => SORT_ASC,
            'kontraktsmoteinklklokkeslett' => SORT_DESC
        ])->all();

        /** @var PropertyDetails[] $properties */
        foreach ($properties as $property) {
            $isOvertagelse =
                $property->kontraktsmoteinklklokkeslett < time()
                && $property->overtagelse > $property->kontraktsmoteinklklokkeslett;
                //&& $property->overtagelse <= time() + (7 * 86400);

            $data['properties'][] = [
                'badge' => $isOvertagelse ? 'Overtagelse' : 'Kontraktsmøte',
                'url' => UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $property->id]),
                'name' => $property->adresse,
                'brokers' => $property->getBrokers(),
                'datetime' => $isOvertagelse 
                    ? date('d.m', $property->overtagelse)
                    : date('d.m / H:i', $property->kontraktsmoteinklklokkeslett),
                'timestamp' => $isOvertagelse
                    ? $property->overtagelse
                    : $property->kontraktsmoteinklklokkeslett
            ];
        }

        $visits = PropertyVisits::find()
            ->joinWith(['propertyDetail', 'user.department'])
            ->select(['property_visits.*', 'property_details.adresse as address', 'property_details.ansatte2_id']);

        if ($this->choosenUser) {
            $visits
                ->where(['user.web_id' => $this->user->web_id])
                ->orWhere(['property_details.ansatte2_id' => $this->user->web_id]);
        }

        if ($this->office) {
            $visits->where(['department.url' => $this->office]);
        }

        $visits = $visits
            ->andWhere('FROM_UNIXTIME(`property_visits`.`fra`, "%Y-%m-%d") BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY')
            ->andWhere('FROM_UNIXTIME(`property_visits`.`til`, "%Y-%m-%d") BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY')
            ->andWhere(['property_details.markedsforingsklart' => -1, 'property_details.solgt' => 0])
            ->orderBy(['property_visits.fra' => SORT_ASC])
            ->all();

        /** @var PropertyVisits[] $visits */
        foreach ($visits as $visit) {
            $data['properties'][] = [
                'badge' => 'visning',
                'url' => UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $visit->property_web_id]),
                'name' => $visit->address,
                'brokers' => $visit->propertyDetail->getBrokers(),
                'datetime' => date('d.m / H:i', $visit->fra),
                'timestamp' => $visit->fra,
            ];
        }

        $propertyActionDates = array_column($data['properties'], 'timestamp');

        array_multisort($propertyActionDates, SORT_ASC, $data['properties']);

        $data['count'] = count($data['news'])
            + count($data['clients'])
            + count($data['properties'])
            + count($data['visits']);

        // TODO: optimise query
        $pdTable = PropertyDetails::tableName();
        $fTable = Forms::tableName();
        $cTable = Client::tableName();
        $outdates = Forms::find()
            ->joinWith(['client','propertyDetails'],false)
            ->select([
                "{$pdTable}.adresse as key",
                'COUNT(*) as count',
                "{$pdTable}.sold_date as date",
                "{$pdTable}.id as p_id",
            ])
            ->where([
                "{$fTable}.broker_id"=>$this->user->web_id,
                "{$fTable}.type"=>Forms::getColdTypes(),
                "{$pdTable}.solgt"=>-1,
                "{$cTable}.status"=>null,
            ])
            ->groupBy([PropertyDetails::tableName() . '.id'])
            ->asArray()
        ;

        $data['outadingProps'] = $outdates->all();
        foreach ($data['outadingProps'] as $i=>$p) {
            $p['date'] = 48*60 - (time() - $p['date'])/60;
            $data['outadingProps'][$i]['date'] = intval($p['date']/60) . ':' . ($p['date']%60);
            $data['outadingProps'][$i]['href'] = Url::toRoute(['oppdrag/detaljer', 'id'=>$p['p_id']]);
        }

        return $data;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionHome()
    {
        $this->layout = 'schala';
        return $this->render('home');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionExample()
    {
        return $this->render('example');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(
                UrlExtended::toRouteAddaptive(['site/index', 'user' => Yii::$app->user->identity->url])
            );
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        if(! $model = new ResetPasswordForm($token)) {

            throw new \yii\web\NotFoundHttpException();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect('/admin/site/login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionForgotPassword() {
        $this->layout = 'login';

        $model = new PasswordResetRequestForm();

        if($model->load(Yii::$app->request->post()) &&  $model->validate()) {
            if($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Cool! Instruksjon for gjenoppretting av passord er sendt til din e-post.');
                return $this->redirect('/admin/site/login');
            }
            Yii::$app->session->setFlash('success', 'error');
        }


        return $this->render('forgot_password', array('model' => $model));

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @param $office
     * @param $userUrl
     *
     * @return array
     */
    private function getLeadsBlock($office = false, $userUrl = false)
    {
        $session = Yii::$app->session;
        if (($start = $session->get('date')['start']) && ($end = $session->get('date')['end'])) {
            $this->dateRange['start'] = $start;
            $this->dateRange['end'] = $end;
        }

        //Todo: replace leadlogtype with forms.status or forms.handle_type
        $leadQuery = Forms::find()
            ->joinWith(['user'])
            ->where(['not in', 'forms.status', ['1013', '1003', '1020', '1017']]);

        if ($partner = Yii::$app->partnerService->selected()) {
            $leadQuery = $leadQuery
                ->joinWith('department')
                ->andWhere(['department.partner_id' => $partner->id]);
        }

        if ($this->office) {
            $leadQuery = $leadQuery
                ->joinWith('department')
                ->andWhere(['department.url' => $this->office]);
        }

        if ($userUrl){
            $leadQuery = $leadQuery->andWhere(['user.url' => $userUrl]);
        }

        $isAdmin = $this->user->hasRole('superadmin');

        $ringeListe = Forms::find()
            ->joinWith(['department', 'client', 'propertyDetails', 'user'], false);

        if (!$isAdmin || ($isAdmin && $userUrl)) {
            $ringeListe->orWhere([
                'forms.department_id' => [$this->user->department_id, null],
                'forms.broker_id' => null
            ]);

            if ($partner = $this->user->partner) {
                $ringeListe->andWhere(['forms.partner_id' => $partner->id]);
            }
        }

        if ($userUrl) {
            $ringeListe->orFilterWhere(['user.url' => $userUrl]);
        }

        if ($department = Yii::$app->departmentService->selected()) {
            $ringeListe
                ->andWhere(['or',
                    ['department.url' => $office, 'forms.broker_id' => null],
                    ['forms.department_id' => null]
                ])
                ->andWhere([
                    'forms.partner_id' => $department->partner_id,
                ]);
        } else {
            if ($isAdmin) {
                $ringeListe->orWhere([
                    'forms.department_id' => null,
                    'forms.broker_id' => null
                ]);
            }
        }

        if ($partner = Yii::$app->partnerService->selected()) {
            $ringeListe->andFilterWhere([
                'forms.partner_id' => $partner->id
            ]);
        }

        $ringeListe->andWhere([
            'forms.type' => Forms::getColdTypes(),
            'property_details.solgt' => -1,
            'client.status' => null
        ]);

        $today = new \DateTime();
        $today->modify('-1 month');

        $ringeListe->andWhere(['>=', 'STR_TO_DATE(property_details.akseptdato, "%d.%m.%Y")', $today->format('Y-m-d')]);


        $varsling = clone $leadQuery;

        $varsling->joinWith('propertyDetails')
            ->andWhere(['or',
                ['forms.type' => 'book_visning', 'property_details.solgt' => 0],
                ['forms.type' => Forms::getHotTypes()]
            ]);

        //TODO: replace tableNames
        $pdTable = PropertyDetails::tableName();
        $fTable = Forms::tableName();
        $cTable = Client::tableName();
        $leadsBlock = array(
            0 => array(
                'isIndividual' => true,
                'preSpan' => 'Hot clients',
                'mobSpan' => 'HOT',
                'label' => 'Pristilbud / Verdivurdering / Salgssum / 3rd party',
                'count' => [
                    'query' => clone $leadQuery,
                    'where' => ['forms.type' => Forms::getHotTypes()],
                    'dateColumn' => 'forms.created_at',
                ],
                'in_processes' => false,
                'href' => UrlExtended::toRoute(['clients/hot']),
            ),
            1 => array(
                'isIndividual' => true,
                'preSpan' => 'Cold clients',
                'mobSpan' => 'COLD',
                'label' => 'Salgsoppgave / Budvarsel / Visningliste',
                'count' => [
                    'query' => clone $leadQuery,
                    'where' => ['forms.type' => Forms::getColdTypes()],
                    'dateColumn' => 'forms.created_at',
                ],
                'in_processes' => false,
                'href' => UrlExtended::toRoute(['clients/cold']),
            ),
            2 => array(
                'isIndividual' => true,
                'preSpan' => 'Varsling',
                'mobSpan' => 'Varsling',
                'label' => 'Ubehandlede',
                'count' => [
                    'query' => $varsling,
                    'where' => ['and',
                        ['not', ['forms.department_id' => null]],
                        ['not in', 'forms.status', [
                            '1014',
                            '1020',
                            '1017',
                            '1011',
                            '1009',
                            '1013',
                            '1008',
                            '1018',
                            '1016',
                            '1010'
                        ]]
                    ],
                    'dateColumn' => 'forms.created_at',
                ],
                'href' => UrlExtended::toRoute(['clients/paminnelser']),
            ),
            /*
            3 => array(
                'isIndividual' => false,
                'preSpan' => 'Oppdrag',
                'label' => 'Oppdrag',
                'count' => [
                    'query' => PropertyDetails::find()
                        ->joinWith(['user', 'department']),
                    'where' => ['IS NOT', 'property.employee_id', null],
                    'dateColumn' => 'property_details.endretdato',
                ],
                'href' => UrlExtended::toRoute(['/oppdrag/index']),
            ), */
            4 => array(
                'isIndividual' => false,
                'preSpan' => 'Ringeliste',
                'label' => 'Personell / Kontor / Felles',
                'count' => [
                    'query' => $ringeListe,
                    'dateColumn' => 'UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, "%d.%m.%Y"))'
                ],
                'href' => UrlExtended::toRoute(['clients/ringeliste']),
            ),
        );

        foreach ($leadsBlock as $i => $block) {
            /** @var ActiveQuery $query */
            $query = $block['count']['query'];

            if (isset($block['count']['where'])) {
                $query = $query->andWhere($block['count']['where']);
            }

            if (isset($block['count']['or_where'])) {
                $query->orWhere($block['count']['or_where']);
            }
            if ($this->dateRange && isset($block['count']['dateColumn'])) {
                $query = $query->andWhere([
                    'between',
                    $block['count']['dateColumn'],
                    $this->dateRange['start'], $this->dateRange['end']
                ]);
            }
            $inProcesses = '';
            if (isset($block['in_processes']) && $block['in_processes']) {
                $processes = clone $query;
                $processes
                    ->andWhere(['<>', 'forms.status', '1011'])
                    ->andWhere(['<>', 'forms.status', '1012']);

                if ($count = $processes->count()) {
                    $inProcesses = "<span class='in-processes'>{$count}</span>";
                }
            }
            $leadsBlock[$i]['count'] = $inProcesses . $query->count();
        }

        return $leadsBlock;
    }

    /**
     * Init Property Table
     * @return array
     */
    protected function getProperties()
    {
        $query = PropertyDetails::find()
            ->select([
                'property_details.*',
                'IFNULL(property_details.oppdragsnummer__prosjekthovedoppdrag, property_details.id) as unique_group'
            ])
            ->joinWith(['department'])
            ->where([
                'solgt' => 0,
                'trukket' => 0,
                'arkivert' => 0,
            ])
            ->andWhere(['>', 'markedsforingsdato', 0])
            ->andWhere(['not', ['oppdragsnummer' => null]]);

//        $session = Yii::$app->session;
//
//        if (($start = $session->get('date')['start']) && ($end = $session->get('date')['end'])) {
//            $query->andWhere(['between', 'property_details.endretdato', $start, $end]);
//        }

        if ($this->office) {
            $query->andWhere([
                'department.url' => $this->office
            ]);
        }
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $departments = Department::find()
                ->select(['web_id', 'short_name', 'url'])
                ->with(['properties' => function (ActiveQuery $query) {
                    $query->select([
                        'property_details.avdeling_id',
                        'property_details.ansatte1_id',
                        'IFNULL(property_details.oppdragsnummer__prosjekthovedoppdrag, property_details.id) as unique_group'
                    ])
                        ->joinWith(['user'])
                        ->where([
                            'property_details.solgt' => 0,
                            'property_details.trukket' => 0,
                            'property_details.arkivert' => 0,
                            'user.inaktiv_status' => -1,
                        ])
                        ->andWhere(['>', 'property_details.markedsforingsdato', 0])
                        ->andWhere(['not', ['property_details.oppdragsnummer' => null]])
                        ->groupBy(['unique_group']);
                }])
                ->where([
                    'partner_id' => $partner->id,
                    'inaktiv' => 0
                ])
                ->asArray()
                ->all();

            return [
                'type' => 'partner',
                'data' => $departments
            ];
        }
        elseif ($this->choosenUser) {
            $query->andWhere([
                'user.url' => $this->choosenUser
            ]);
        } else {
            $partners = Partner::find()
                ->joinWith(['activeDepartments' => function (ActiveQuery $query){
                    $query->select([
                        'partnerDepartments.web_id as web_id',
                        'partnerDepartments.short_name as dep_name',
                        'partnerDepartments.url as dep_url',
                        'partnerDepartments.partner_id'
                    ])
                        ->with(['properties' => function (ActiveQuery $query) {
                            $query->select([
                                'property_details.avdeling_id',
                                'property_details.ansatte1_id',
                                'IFNULL(property_details.oppdragsnummer__prosjekthovedoppdrag, property_details.id) as unique_group'
                            ])
                                ->joinWith(['user'])
                                ->where([
                                    //'property_details.markedsforingsklart' => -1,
                                    'property_details.solgt' => 0,
                                    'property_details.trukket' => 0,
                                    'property_details.arkivert' => 0,
                                    'user.inaktiv_status' => -1,
                            ])
                                ->andWhere(['>', 'property_details.markedsforingsdato', 0])
                                ->andWhere(['not', ['property_details.oppdragsnummer' => null]])
                                ->groupBy(['unique_group']);
                        }]);
                }])
                ->asArray()
                ->all();

            foreach ($partners as $prt_id => $partner) {
                if ($partners[$prt_id]["activeDepartments"]) {
                    $partners[$prt_id]["pd_count"] = 0;
                    $partners[$prt_id]["dep_count"] = count($partner["activeDepartments"]);
                    foreach ($partner["activeDepartments"] as $dp_id => $activeDepartment) {
                        $department_pd_count = count($activeDepartment["properties"]);
                        $partners[$prt_id]["activeDepartments"][$dp_id]["pd_count"] = $department_pd_count;
                        $partners[$prt_id]["pd_count"] += $department_pd_count;
                        unset($partners[$prt_id]["activeDepartments"][$dp_id]["properties"]);
                    }
                } else {
                    unset($partners[$prt_id]);
                }
            }

            return [
                'type' => 'notUserAndOffice',
                'data' => $partners
            ];
        }

        $properties = $query
            ->joinWith(['user', 'propertyImage', 'propertyAds'])
            ->with(['propertyVisits'])
            ->groupBy(['unique_group'])
//            ->orderBy(['adresse' => SORT_ASC])
            ->all();

        $data = [];

        ArrayHelper::multisort($properties, "adresse", SORT_ASC);
        $alphabet = 0;
        /** @var PropertyDetails[] $properties */
        foreach ($properties as $property) {
            $data[] = [
                'id' => $property->id,
                'alphabet' => ++$alphabet,
                'address' => $property->adresse,
                'oppdragsnummer' => $property->oppdragsnummer,
                'background' => $property->posterPath(),
                'detail_url' => UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $property->id]),
                'statistics_url' => UrlExtended::toRoute(['oppdrag/statistikk', 'id' => $property->id]),
                'parties_concerned_url' => UrlExtended::toRoute(['oppdrag/interessenter', 'id' => $property->id]),
                'finn_viewings' => $property->propertyAds->finn_viewings ?? 0,
                'markedsforing' => $this->getMarkedsforing($property->oppdragsnummer),
                'eiendom_viewings' => $property->propertyAds->eiendom_viewings ?? 0,
                'user_img' => $property->user->urlstandardbilde ?? 0,
                'date' => $this->getVisitsDate($property->id),
                'leads' => Forms::getLeadsCount($property->id)
            ];
        }

        return [
            'type' => 'userOrOffice',
            'data' => $data
        ];
    }

    /**
     * @return array|Query
     */
    private function getVisitsPreview()
    {
        $visitsPreviews = (new Query())
            ->select([
                'property_visits.visit_id as visitId',
                'property_visits.property_web_id as propertyId',
                'property_visits.fra as date',
                'property_details.adresse as address',
                'property_details.id as pWebId',
                'property_details.finn_orderno as finnNo',
                'property_details.eiendom_viewings',
                'property_details.finn_viewings',
                'property_details.oppdragsnummer as oppNum',
                'forms.type as formType',
                'image.urlstorthumbnail as pImageSrc',
                'user.urlstandardbilde as uImageSrc',
                'count(*) as count'
            ])
            ->from('property_visits')
            ->leftJoin('property_details', 'property_visits.property_web_id = property_details.id')
            ->leftJoin('user', 'property_details.ansatte1_id = user.web_id')
            ->leftJoin('forms', 'property_details.id = forms.target_id')
            ->leftJoin('image', 'property_details.id = image.propertyDetailId AND image.nr = 1')
            ->where(['user.web_id' => $this->user->web_id,])
            ->orWhere(['property_details.ansatte2_id' => $this->user->web_id])
            ->andWhere(['property_details.markedsforingsklart' => -1, 'solgt'=>0]);

        $dateFormat = "Y-m-d H:i:s";

        $visitsPreviews = $visitsPreviews
            ->groupBy(['pWebId','forms.type'])
            ->orderBy(['date' => SORT_ASC])
            ->limit(10)
            ->all();

        $buff = [];

        foreach ($visitsPreviews as $v) {
            $id = $v['visitId'];

            if (!isset($buff[$id])) {
                $buff[$id] = $v;

                unset($buff[$id]['formType'], $buff[$id]['count']);

                $buff[$id]['leads'] = Forms::getLeadsCount($id);
                
                $buff[$id]['date'] = $this->getVisitsDate($v['propertyId']);

                $buff[$id]['markedsforing'] = $this->getMarkedsforing($v['oppNum']);

                $buff[$id]['uImageSrc'];

                $buff[$id]['detaljerHref'] = Url::toRoute(['oppdrag/detaljer/', 'id' => $v['propertyId']]);
                $buff[$id]['statistikkHref'] = Url::toRoute(['oppdrag/statistikk', 'id' => $v['propertyId']]);
                $buff[$id]['interessenterHref'] = Url::toRoute(['oppdrag/interessenter/', 'id' => $v['propertyId']]);
            }

            if (isset($buff[$id]['leads'][$v['formType']])) {
                $buff[$id]['leads'][$v['formType']] = $v['count'];
            }

        }

        return $buff;
    }

    /**
     * @param $id
     * @return array
     */
    private function getVisitsDate($id)
    {
        $dateFormat = "Y-m-d H:i:s";
        $visits = PropertyVisits::find()
            ->select(['fra', 'til'])
            ->where(['property_web_id' => $id])
            ->andWhere(['>', 'til', time()])
            ->groupBy(['fra'])
            ->asArray()
            ->limit(2)
            ->all();

        return $visits;
    }

    public function actionSetSession()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $label = Yii::$app->request->get('label');
            $start = Yii::$app->request->get('start');
            $end = Yii::$app->request->get('end');
            $session = Yii::$app->session;
            if ($label === 'Alle') {
                $session->remove('date');
                return false;
            }
            $session->set('date', ['label' => $label, 'start' => $start, 'end' => $end]);
            return $session->has('date') ? ['label' => $session->get('date')['label'], 'start' => $session->get('date')['start'], 'end' => $session->get('date')['end']] : false;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetSession()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            return $session->has('date') ? ['label' => $session->get('date')['label'], 'start' => $session->get('date')['start'], 'end' => $session->get('date')['end']] : false;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSendSms()
    {
        $model = new Sms();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $smsSender = new SnsComponent();
                $smsSender->setSenderId(strval($model->from));
                $smsSender->publishSms($model->message, $model->phone);
                if (($lead_id = Yii::$app->request->post("lead_id")) && ($lead = Forms::findOne(["id" => $lead_id]))) {
                    $lead->addLog(1016, "<span>{$model->message}</span>");
                }
                Yii::$app->session->setFlash('success', 'Vellykket sendt');
                return Json::encode(['success' => 'Vellykket sendt']);
            }
            return Json::encode($model->getErrors());
        }
        return $this->render('send-sms', [
            'model' => $model
        ]);
    }

    public function actionMailing()
    {
        $request = Yii::$app->request;
        $model = new Mail;
        $model->scenario = Mail::SCENARIO_LEAD;
        if ($request->isPost && $model->load($request->post())) {

            if (!$model->validate()) {
                return Json::encode($model->getErrors());
            }

            $mailer = new SesMailer;

            $response = $mailer->sendMail($model->message, $model->subject, [$model->email], $model->from);

            if (!$mailer->fails()) {
                if (($lead_id = Yii::$app->request->post("lead_id")) && ($lead = Forms::findOne(["id" => $lead_id]))) {
                    $lead->addLog(1021, "<span>{$model->message}</span>");
                }
                return Json::encode(['success' => 'Vellykket sendt']);
            }

            return Json::encode($response);
        }

        return $this->render('mailing', compact('model'));
    }

    /**
     * Displays User income statistc :: Dashboard
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionIncome()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $year = Yii::$app->request->get('year', date('Y'));
        $month = Yii::$app->request->get('month');
        $object = null;
        $condition = null;
        $userId = Yii::$app->request->get('userId');

        $dateArr = $this->assoc_array_slice(Salgssnitt::getAllYears(), [$year]);

        $percent = 0;

        if ($month === 'all') {
            $start = strtotime($year . '-01-01');
            $end = time();
        } else if ($month === '') {
            $start = strtotime($year . '-01-01');
            $end = strtotime($year . '-12-31');
            if ($year === $year) {
                $dateArr[$year] = array_slice($dateArr[$year], 0, date('n'));
            }
        } else {
            $start = strtotime($year . '-' . $month . '-01');
            $end = strtotime($year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year));
            $dateArr[$year] = [
                0 => $dateArr[$year][intval($month)]
            ];
        }

        $user_r = new UserRating($start, $end);

        if ($userId){
            $object = User::findOne(['id' => $userId]);
            $user_r->user = $object;
        } else if ($this->choosenUser) {
            $object = User::findOne(['url' => $this->choosenUser]);
            $user_r->user = $object;
        } else if ($this->office) {
            $object = Department::findOne(['url' => $this->office]);
            $user_r->department = $object;
        }else if ($this->partner) {
            $object = Partner::findOne(['id' => $this->partner]);
            $user_r->partner = $object;
        }

        $plans = $object ? $object->getBudsjetts([$year]) : Budsjett::getBudsjettsByYear([$year]);
        foreach ($dateArr as $years) {
            foreach ($years as $item) {
                $percent += $item;
            }
        }


        $befaringerDoneCount = $user_r->getIncomeRating('befaringer');
        $signeringerDoneCount = $user_r->getIncomeRating('signeringer');
        $salgDoneCount = $user_r->getIncomeRating('salg');
        $provisjonDoneSum = $user_r->getIncomeRating('provisjon');


        $befaringer = ceil($plans['befaringer'] / 100 * $percent);
        $signeringer = ceil($plans['salg'] / 100 * $percent);
        $salg = ceil($plans['salg'] / 100 * $percent);
        $provisjon = ceil($plans['inntekt'] / 100 * $percent);


        return [
            'object' => $object,
            'income_data' => [
                'befaringer' => [
                    'propertyDetailsCount' => number_format($befaringer, 0, ' ', ' '),
                    'count' => number_format($befaringerDoneCount, 0, ' ', ' '),
                    'price' => $befaringer == 0 ? 0 : ceil($befaringerDoneCount * 100 / $befaringer),
                ],
                'signeringer' => [
                    'propertyDetailsCount' => number_format($signeringer, 0, ' ', ' '),
                    'count' => number_format($signeringerDoneCount, 0, ' ', ' '),
                    'price' => $signeringer == 0 ? 0 : ceil($signeringerDoneCount * 100 / $signeringer),
                ],
                'salg' => [
                    'propertyDetailsCount' => number_format($salg, 0, ' ', ' '),
                    'count' => number_format($salgDoneCount, 0, ' ', ' '),
                    'price' => $salg == 0 ? 0 : ceil($salgDoneCount * 100 / $salg),
                ],
                'provisjon' => [
                    'propertyDetailsCount' => number_format($provisjon, 0, ' ', ' '),
                    'count' => number_format($provisjonDoneSum, 0, ' ', ' '),
                    'price' => $provisjon == 0 ? 0 : ceil($provisjonDoneSum * 100 / $provisjon),
                ],
            ]
        ];

    }


    /**
     * @param $array
     * @param $keys
     * @return array
     */
    function assoc_array_slice($array, $keys)
    {
        $slice = [];
        foreach ($keys as $key) {
            if (isset($array[$key])) $slice[$key] = $array[$key];
        }
        return $slice;
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRating()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        $user_r = new UserRating(strtotime('January 1st'), strtotime('December 31st'));

//        $user_r->partner = $this->partner ? Partner::findOne(['id' => $this->partner]) : null;
//        $user_r->department = $this->office ? Department::findOne(['url' => $this->office]) : null;

        $userRatings = [
            'aktiviteter' => [],
            'salg' => $user_r->getRatingByType('salg'),
            'provisjon' => $user_r->getRatingByType('provisjon'),
            'signeringer' => $user_r->getRatingByType('signeringer')
        ];

        $userRatings['aktiviteter'] = $userRatings['salg'];
        $befaringer = $user_r->getRatingByType('befaringer');
        $visits = $user_r->getVisitsRating();

        foreach ($userRatings['aktiviteter'] as $k => $v) {
            $userRatings['aktiviteter'][$k]["count"] = $v["count"] * 2;
        }

        $userRatings['aktiviteter'] = count($befaringer) > count($userRatings['aktiviteter'])
            ? StaticMethods::ratingArrayMix($befaringer, $userRatings['aktiviteter'])
            : StaticMethods::ratingArrayMix($userRatings['aktiviteter'], $befaringer);

        $userRatings['aktiviteter'] = count($userRatings['aktiviteter']) > count($visits)
            ? StaticMethods::ratingArrayMix($userRatings['aktiviteter'], $visits)
            : StaticMethods::ratingArrayMix($visits, $userRatings['aktiviteter']);

//        $user_r->user = $this->choosenUser ? User::findOne(['url' => $this->choosenUser]) : null;

        foreach ($userRatings as $key => $value) {
            ArrayHelper::multisort($userRatings[$key], ["count", "user.short_name"], [SORT_DESC, SORT_ASC]);
            $userRatings[$key] = $user_r->arraySlice($userRatings[$key]);
        }

        $choosenUser = $this->user;
        return $this->renderPartial('_user-rating', compact('userRatings', 'choosenUser'));

    }


    /**
     * @param $oppNum
     * @return int
     */
    private function getMarkedsforing($oppNum)
    {
        $digital_marketing = DigitalMarketing::find()
            ->select(['stats'])
            ->where(['source_object_id' => $oppNum])
            ->andWhere(['not', ['stats' => null]])
            ->asArray()
            ->column();

        $clicks = 0;
        foreach ($digital_marketing as $item) {
            $arr = json_decode($item, true);
            $clicks += isset($arr['clicks'])? $arr['clicks'] : false;
        }

        return $clicks;
    }


    public function actionTheme($color)
    {
        $theme = Theme::find()->where(["color" => $color])->one();
        if ($theme) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $user->theme_id = $theme->id;
            $user->save(false);
        }
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSearchLocations()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $query = urlencode(\Yii::$app->request->get('q'));

        $url = "https://kart.finn.no/map/api/geo/query/solr.json?q={$query}&limit=5";

        return json_decode(file_get_contents($url), true);
    }

    private function getAccordion()
    {
        if ($this->user->hasRole('broker')) return false;

        $accordion = [];
        $users = User::find()
            ->select(["user.id", "user.navn", "user.urlstandardbilde", "user.id_avdelinger"])
            ->joinWith([
                'partner' => function (ActiveQuery $query) {
                    $query->select(["partner.id", "partner.name"]);
                },
                'department' => function (ActiveQuery $query) {
                    $query->select(["department.navn", "department.short_name", "department.web_id"]);
                }
            ])
            ->andWhere(['and',
                ['=', 'user.inaktiv_status', -1],
                ['not', ['department.inaktiv' => 1]],
                ['department.original_id' => null]
            ])
            ->groupBy(['user.web_id'])->asArray()->all();


        foreach ($users as $user) {
            if (!isset($accordion[$user['partner']['id']])) {
                $accordion[$user['partner']['id']] = $user['partner'];
                $accordion[$user['partner']['id']]['departments'] = [];
            }
            if (!isset($accordion[$user['partner']['id']]['departments'][$user['department']["web_id"]])) {
                $accordion[$user['partner']['id']]['departments'][$user['department']["web_id"]] = $user['department'];
                $accordion[$user['partner']['id']]['departments'][$user['department']["web_id"]]['users'] = [];
            }
            $accordion[$user['partner']['id']]['departments'][$user['department']["web_id"]]['users'][] = [
                "id" => $user["id"],
                "navn" => $user["navn"],
                "urlstandardbilde" => $user["urlstandardbilde"],
                "id_avdelinger" => $user["id_avdelinger"]
            ];
        }

        ArrayHelper::multisort($accordion, "name", SORT_ASC);
        return $accordion;
    }

}
