<?php

namespace backend\controllers;

use backend\components\PermitionControll;
use backend\components\UrlExtended;
use backend\controllers\actions\AllClientsDataTableAction;
use backend\controllers\actions\BoligvarslingAction;
use backend\controllers\actions\CallingListClientsDataTableAction;
use backend\controllers\actions\ClientDataTableAction;
use backend\controllers\actions\ClientLeadsDataTableAction;
use backend\controllers\actions\FavoritesDataTableAction;
use backend\controllers\actions\PotentialClientsDataTableAction;
use common\models\Boligvarsling;
use common\models\Client;
use common\models\Department;
use common\models\Forms;
use common\models\LeadLog;
use common\models\PropertyDetails;
use common\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Lead controller
 */
class ClientsController extends RoleController
{
    private $title = false;
    /** @var ActiveQuery $leadsQuery */
    private $leadsQuery = false;
    private $office = false;


    /**
     * Init controller
     */
    public function init()
    {
        Yii::$app->view->params[Yii::$app->request->pathInfo] = 'active';
        $this->leadsQuery = Forms::find();
        parent::init();
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

    public function beforeAction($action)
    {
        if (in_array($action->id, ['map-table', 'calling-list-table'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
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

            'data-table' => [
                'class' => ClientDataTableAction::class
            ],

            'potential-table' => [
                'class' => PotentialClientsDataTableAction::class
            ],

            'calling-list-table' => [
                'class' => CallingListClientsDataTableAction::class
            ],

            'clients-table' => [
                'class' => AllClientsDataTableAction::class
            ],

            'client-leads-table' => [
                'class' => ClientLeadsDataTableAction::class
            ],

            'favorites-table' => [
                'class' => FavoritesDataTableAction::class
            ],

            'boligvarsling-table' => BoligvarslingAction::class,
        ];
    }

    /**
     * @return mixed
     */
    private function extendRequest()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $this->layout = 'ajax';
        }
        return;
    }

    /**
     * Display leads list
     *
     * @param bool $type
     * @param bool|string $partner
     * @param bool|string $office
     * @param bool|string $user
     * @param bool $filter
     *
     * @return string
     */
    public function actionIndex($type = false, $partner = false, $office = false, $user = false, $filter = false)
    {
        if (!$type) {
            $type = array_merge(Forms::getHotTypes(), Forms::getColdTypes());
        }

        $formTypes = Forms::find()
            ->select('type')
            ->where(['in', 'type', $type])
            ->groupBy('type');

        $formTypes = array_column($formTypes->all(), 'type');
        $title = $this->title;

        return $this->render('index', compact('title', 'type', 'office', 'partner', 'formTypes', 'user', 'filter'));
    }

    /**
     * Displays hot leads page.
     *
     * @param bool|string $partner
     * @param bool|string $office
     * @param bool|string $user
     *
     * @return string html
     */
    public function actionHot($partner = false, $office = false, $user = false)
    {
        $this->title = 'Hot clients';
        $filter = Yii::$app->request->get('filter');

        return $this->actionIndex(Forms::getHotTypes(), $partner, $office, $user, $filter);
    }

    /**
     * Displays hot leads page.
     *
     * @param bool|string $partner
     * @param bool|string $office
     * @param bool|string $user
     *
     * @return string html
     */
    public function actionCold($partner = false, $office = false, $user = false, $form_type = false)
    {
        $this->title = 'Cold clients';
        $filter = Yii::$app->request->get('filter');
        $types = Forms::getColdTypes();
        return $this->actionIndex($types, $partner, $office, $user, $filter);
    }

    /**
     * Displays visning leads page.
     *
     * @param bool|string $partner
     * @param bool|string $office
     * @param bool|string $user
     *
     * @return string html
     */
    public function actionVisning($partner = false, $office = false, $user = false)
    {
        $this->title = 'Visningspåmelding';
        $filter = Yii::$app->request->get('filter');

        return $this->actionIndex(['book_visning'], $partner, $office, $user, $filter);
    }

    /**
     *
     *
     * @param bool $office
     * @param bool $user
     *
     * @return string
     */
    public function actionFavoritter($office = false, $user = false)
    {
        return $this->render('favorites', compact('office', 'user'));
    }

    /**
     * Displays leads which has log with type -> Påminnelse
     *
     * @param bool|string $partner
     * @param bool|string $office
     * @param bool|string $user
     *
     * @return string
     */
    public function actionPaminnelser($partner = false, $office = false, $user = false)
    {
        $this->title = 'Leads';

        $types = array_merge(Forms::getHotTypes(), ['book_visning']);

        return $this->actionIndex($types, $partner, $office, $user);
    }

    /**
     * Displays leadspage.
     *
     * @param $id
     * @return string
     */
    public function actionDetaljer($id)
    {
        /** @var Forms $lead */
        $lead = Forms::find()
            ->joinWith(['propertyDetails', 'logs.user.department'])
            ->select([
                'forms.*',
                'property_details.oppdragsnummer',
            ])
            ->where(['forms.id' => $id])
            ->one();

        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (!$lead || $lead->hasType('fjernet') && !$user->hasRole('superadmin')) {
            return $this->render('//errors/404');
        }

        $accessMap = [
            // 'superadmin' => [],
            'partner' => ['department.partner_id' => $user->department->partner_id,],
            'director' => ['and',
                ['or',
                    ['user.role' => ['director', 'superadmin'],],
                    ['user.id_avdelinger' => Yii::$app->user->identity->id_avdelinger,]
                ],
                ['department.partner_id' => $user->department->partner_id,],
            ],
            'broker' => ['user.id_avdelinger' => Yii::$app->user->identity->id_avdelinger,],
        ];
        $where = PermitionControll::hasAccess('delegateList', $accessMap);
        $departments = false;
        $partners = new ArrayDataProvider([
            'allModels' => [],
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);

        if ($where) {
            if (is_array($where)) {
                $where = $where[0];
            }
            $where = ['and',
                ['=', 'user.inaktiv_status', -1],
                ['not', ['department.inaktiv' => 1]],
                ['department.original_id' => null],
                $where,
            ];

            $users = User::find()
                ->select([
                    'user.web_id',
                    'user.navn',
                    'user.id_avdelinger',
                ])
                ->joinWith(['partner', 'department'])
                ->where($where)
                ->groupBy(['user.web_id'])
                ->asArray()
                ->all();

            $partnerModels = [];

            foreach ($users as $u) {
                if (!isset($partnerModels[$u['partner']['id']])) {
                    $partnerModels[$u['partner']['id']] = $u['partner'];
                    $partnerModels[$u['partner']['id']]['departments'] = [];
                }
                if (!isset($partnerModels[$u['partner']['id']]['departments'][$u['id_avdelinger']])) {
                    $partnerModels[$u['partner']['id']]['departments'][$u['id_avdelinger']] = $u['department'];
                    $partnerModels[$u['partner']['id']]['departments'][$u['id_avdelinger']]['users'] = [];
                }
                $partnerModels[$u['partner']['id']]['departments'][$u['id_avdelinger']]['users'][] = $u;
            }

            ArrayHelper::multisort($partnerModels, "name", SORT_ASC);
            $partners->setModels($partnerModels);
        }

        $logs = new ArrayDataProvider([
            'allModels' => $lead->logs,
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);
        if (isset($lead->logs[0])) {
            $lastLog = $lead->logs[0];
        } else {
            $lastLog = new LeadLog();
            $lastLog->type = 'Unknown';
        }

        $logModel = new LeadLog();
        $customLogs = [];

        foreach (['1014', '1020', '1017', '1011', '1009', '1013', '1008', '1018'] as $type) {
            $customLogs[$type] = Yii::t('lead_log', $type);
        }

        Yii::$app->view->params[$lead->isHot() ? 'clients/hot' : 'clients/cold'] = 'active';

        $permitions = [
            'delegate' => 'delegate',
            'log' => 'log',
            'ufordelt' => 'ufordelt',
        ];

        if (!$lead->hasType('fjernet')) {
            // In development
            $permitions['delete'] = 'delete';
        }

        if ($lead->isCold()) {
            $permitions['create_hot_lead'] = 'create_hot_lead';
        }

        $actions = PermitionControll::hasAccess('leadActions', $permitions);
        $actions = is_array($actions) ? $actions : [];
        $office = Yii::$app->request->get('office');
        $id = Yii::$app->request->get('id');

        $msg = $user->short_name;
        if ($user->department) {
            $msg .= ' / ' . $user->department->short_name;
        }
        $allDeps = !($lead->isHot() && PermitionControll::hasAccess('ufordelt')) ? [] :
            Department::find()->select(
                ['web_id', 'short_name']
            )->where(['inaktiv' => 0])->asArray()->all();;

        if (!$user->hasRole(User::TYPE_SUPER_ADMIN) || $lead->isOwner()) {
            $lead->addLogOnce([
                'type' => LeadLog::TYPE_SEED,
            ]);
        }

        return $this->render('detaljer', compact(
                'lead',
                'actions',
                'logs',
                'partners',
                'logModel',
                'customLogs',
                'lastLog',
                'office',
                'allDeps',
                'id'
            )
        );
    }

    /**
     * Delegate an user to the lead.
     *
     * @param $id
     * @param $d_id
     *
     * @return array
     *
     */
    public function actionDelegate($id, $d_id)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $accessMap = [
            'partner' => ['department.partner_id' => $user->department->partner_id,],
            'director' => ['and',
                ['or',
                    ['user.role' => ['director', 'superadmin'],],
                    ['user.id_avdelinger' => Yii::$app->user->identity->id_avdelinger,]
                ],
                ['department.partner_id' => $user->department->partner_id,],
            ],
            'broker' => ['user.id_avdelinger' => Yii::$app->user->identity->id_avdelinger,],
        ];
        $where = PermitionControll::hasAccess('delegate', $accessMap);
        if (!$where) {// No access to this action
            return [
                'success' => false,
                'message' => 'Permition Denied',
            ];
        }
        if (is_array($where)) {
            $where = $where[0];
        }
        $where = ['and',
            ['=', 'user.inaktiv_status', -1],
            $where,
            ['user.web_id' => $d_id],
        ];
        $user = User::find()->joinWith(['department'])->where($where)->one();

        if (!$user) {// Cant delegate to broker or broker not found
            return [
                'success' => false,
                'message' => 'Permition Denied',
            ];
        }

        $lead = Forms::findOne($id);
        if ($lead->broker_id == $user->web_id) {
            return [
                'success' => false,
                'message' => 'Cant delegate to same broker',
            ];
        }
        $lead->delegate($user, 'delegert', true);
        return [
            'success' => true,
            'user' => $user->navn,
            'dep' => $user->department->short_name,
        ];
    }

    /**
     * Ufordelt lead to department.
     *
     * @param $id
     * @param $d_id
     *
     * @return array
     *
     */
    public function actionUfordelt($id, $d_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $lead = Forms::findOne($id);
        if (!$lead->isHot() || !PermitionControll::hasAccess('ufordelt')) {// No access to this action
            return [
                'success' => false,
                'message' => 'Permition Denied',
            ];
        }
        $dep = Department::findOne(['web_id' => $d_id]);
        if (!$dep || !$lead) {
            return [
                'success' => false,
                'message' => 'Incorrect data',
            ];
        }
        $lead->ufordelt($dep);
        return [
            'success' => true,
            'dep' => $dep->short_name,
        ];
    }

    /**
     * Displays leadspage.
     *
     * @return string
     */
    public function actionMarkedsforing()
    {
        return $this->render('markedsforing');
    }

    /**
     * Displays leadspage.
     *
     * @return string
     */
    public function actionSolgte()
    {
        return $this->render('solgte');
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdd_log($id)
    {
        $request = Yii::$app->request;

        $log = new LeadLog();
        $log->load($request->post());

        $lead = Forms::findOne($id);
        $lead->addLog($log->getAttribute('type'), $log->message, $log->notify_at, $log->inform_in_advance);
        $lead->favorite = $request->post('favorite', false) === 'on';
        $lead->save();

        return $this->redirect(UrlExtended::toRoute(['clients/detaljer', 'id' => $id]));
    }

    /**
     * @param bool $lead_id
     * @param bool $token
     * @return string|Response
     */
    public function actionCheckUrl($lead_id = false, $token = false)
    {
        /** @var Forms $form */
        $form = Forms::find()
            ->joinWith(['leadLogs'])
            ->where([
                'forms.id' => $lead_id,
                'forms.token' => $token
            ])
            ->one();

        if (!$form) {
            return $this->render('//errors/404');
        }

        if (!array_key_exists(
            '1007',
            ArrayHelper::map($form->leadLogs, 'type', 'type')
        )) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $message = "<span>{$user->navn}</span><span>{$user->department->short_name}</span>";
            $form->addLog('1007', $message);
        }

        return $this->redirect(UrlExtended::toRoute(['clients/detaljer', 'id' => $form->id]));
    }

    /**
     * @param $id
     *
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionToggleType($id)
    {
        return [
            'error' => true,
            'Message' => 'Deprecated action',


        ];

    }

    /**
     * @param $id
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSoftDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $accessMap = [
            'partner' => ['department.partner_id' => $user->department->partner_id,],
            'director' => ['department_id' => Yii::$app->user->identity->id_avdelinger,],
            'broker' => ['broker_id' => Yii::$app->user->identity->web_id,]
        ];
        $where = PermitionControll::hasAccess('softDelete', $accessMap);

        if (!$where) {// No access to this action
            return [
                'success' => false,
                'message' => 'Permition Denied',
            ];
        }

        // Merege condition with id condition or just id condition if there is no restriction ( ex. superAdmin )
        $where = is_array($where) ? [
            'and',
            $where,
            ['id' => $id],
        ] : ['id' => $id];
        //TODO:remove join after adding partner_id to leads
        $form = Forms::find()->joinWith(['department',])->where($where);

        if (!$form) {// No such a form or has no permition
            return [
                'success' => false,
                'message' => 'No such a Form',
            ];
        }
        $form->addLog('1003', "$form->type &rarr; fjernet");
        $form->status = '1003';
        $form->save();
        return [
            'success' => true
        ];
    }

    /**
     * Display create hot lead form or create lead
     * @return string|html|json
     */
    public function actionCreate($id = null)
    {
        $model = new Forms();
        $model->scenario = Forms::SCENARIO_OTHER;
        if ($model->load(Yii::$app->request->post())) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $model->source_id = 0;
            $model->department_id = $user->id_avdelinger;
            $model->broker_id = strval($user->web_id);
            if ($model->save()) {
                $return = Json::encode([
                    'success' => true,
                    'url' => Yii::$app->request->post('after_action') === 'list'
                        ? UrlExtended::toRoute(['clients/hot'])
                        : UrlExtended::toRoute(['clients/detaljer', 'id' => $model->id])
                ]);

                $model->addLog('1012', 'Lagt manuelt');
            } else {
                $return = Json::encode($model->getErrors());
            }
            return $return;
        }
        $m = !$id ? false : Forms::findOne([
            'id' => $id,
            'type' => Forms::getColdTypes(),
        ]);
        $model = $m ? $m : $model;
        $model->id = null;
        $model->type = null;
        $model->i_agree = true;
        $model->name = html_entity_decode($model->name);
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * convert gmap request to active query
     * @param $query ActiveQuery
     */
    private function handleGmapRequest($query)
    {
        $post = Yii::$app->request->post();
        unset($post['_csrf-backend']);
        unset($post['Forms']['post_number']);
        $propTable = PropertyDetails::tableName();
        $sep = '-';
        $columnMap = [
            'price_range' => $propTable . '.prisantydning',
            'area_range' => $propTable . '.prom',
            'property_type' => $propTable . '.type_eiendomstyper',
        ];

        foreach ($post as $table => $columns) {
            foreach ($columns as $column => $value) {
                if (!$value) {
                    continue;
                }
                $column = isset($columnMap[$column]) ? $columnMap[$column] : $column;
                if (strpos($value, $sep) !== false) {// Is range input
                    $value = explode($sep, $value);
                    if ('created_at' == $column) {
                        $value[0] = time() - 60 * 60 * 24 * 30 * $value[0];
                        $value[1] = time() - 60 * 60 * 24 * 30 * $value[1];
                        $buff = $value[0];
                        $value[0] = $value[1];
                        $value[1] = $buff;
                    }
                    $where = ['between', $column, intval($value[0]), intval($value[1])];
                } else {
                    $value = is_array($value) || strpos($value, ',') === false ? $value : explode(',', $value);
                    $where = [$column => $value];
                }
                $query = $query->andWhere($where);
            }
        }
        return $query;
    }

    /**
     * Return leads coordinates in json format
     */
    function actionGetCoordMap()
    {
        $coords = Forms::find()
            ->joinWith(['postNumber', 'propertyDetails'], false)
            ->where(['NOT', ['all_post_number.post_number' => NULL]])
            ->select('
                forms.id, 
                forms.post_number, 
                all_post_number.lat, 
                all_post_number.lon
            ');
        $coords = $coords->andWhere(['forms.type' => Forms::getInterestedTypes()]);
        //$coords = $this->handleGmapRequest($coords);

        $coords = $coords->asArray()->all();
        $result = [];
        foreach ($coords as $c) {
            if (!isset($result[$c['lat']])) {
                $result[$c['lat']] = [];
            }
            if (!isset($result[$c['lat']][$c['lon']])) {
                $result[$c['lat']][$c['lon']] = [];
            }
            $result[$c['lat']][$c['lon']][] = $c['post_number'];
        }
        $coords = [];
        $i = 0;
        foreach ($result as $lat => $c) {
            foreach ($c as $lon => $postNumbers) {
                $coords[$i] = [
                    'lat' => floatval($lat),
                    'lng' => floatval($lon),
                    'postNumbers' => $postNumbers,
                ];
                $i++;
            }
        }
        return json_encode($coords);
    }

    /**
     * @return string
     */
    public function actionPotential()
    {
        if (Yii::$app->request->isAjax) {
            if ($address = Yii::$app->request->get('address')) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $markers = PropertyDetails::find()->select(["CONCAT_WS(' ', `adresse`, `postnummer`, `poststed`) AS address", "lat", "lng"])
                    ->where(['like', "CONCAT_WS(' ', `adresse`, `postnummer`, `poststed`)", $address])
                    ->andWhere(['not', ['lat' => null, 'lng' => null]])
                    ->asArray()->all();
                return $markers ? $markers : null;
            }
            return null;
        }


        Yii::$app->view->title = 'Mulige kjøpere';

        $model = new Forms;

        $formTypes = Forms::find()
            ->select('type')
            ->where(['in', 'type', Forms::getInterestedTypes()])
            ->distinct()
            ->all();

        $formTypes = ArrayHelper::map($formTypes, 'type', 'type');

        $propTypes = PropertyDetails::find()
            ->select([
                "(CASE WHEN property_details.type_eiendomstyper NOT IN ('Leilighet', 'Enebolig','Tomannsbolig','Hytte','Rekkehus')
                  THEN 'Andre'
                  WHEN property_details.type_eiendomstyper IN ('Leilighet', 'Enebolig','Tomannsbolig','Hytte','Rekkehus')
                  THEN type_eiendomstyper END) AS type_eiendomstyper",
                "(CASE WHEN property_details.type_eiendomstyper NOT IN ('Leilighet', 'Enebolig','Tomannsbolig','Hytte','Rekkehus')
                  THEN 'Andre'
                  WHEN property_details.type_eiendomstyper IN ('Leilighet', 'Enebolig','Tomannsbolig','Hytte','Rekkehus')
                  THEN type_eiendomstyper  END) AS type"
            ])
            ->groupBy('type')
            ->orderBy([new Expression('FIELD(type, "Leilighet", "Enebolig", "Tomannsbolig", "Rekkehus", "Hytte", "Forretning", "Tomt", "Andre")')])
            ->asArray()
            ->distinct()
            ->all();

        $propTypes = ArrayHelper::map($propTypes, 'type_eiendomstyper', 'type_eiendomstyper');

        return $this->render('potential', compact('model', 'formTypes', 'propTypes'));
    }

    public function actionContact()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        /** @var User $user */
        $user = Yii::$app->user->identity;
        $request = Yii::$app->request;

        /** @var Forms $form */
        $form = Forms::find()
            ->with(['logs' => function (ActiveQuery $query) {
                $query->where(['type' => '1002']);
            }])
            ->where(['forms.id' => $request->post('id')])
            ->one();

        if (empty($form->logs)) {
            $form->delegate($user, '1002');
        }

        $form->addLog($request->post('type'), "<span>{$user->navn}<span> {$user->department->short_name}</span>");

        return [
            'success' => true
        ];
    }

    /**
     * Show clients list.
     *
     * @param bool $office
     * @param bool $user
     *
     * @return string
     */
    public function actionAlle($office = false, $user = false)
    {
        return $this->render('all',
            compact('office', 'user')
        );
    }

    /**
     * Show client detail.
     *
     * @param int $id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionInfo($id)
    {
        $client = Client::find()
            ->select([
                '{{client}}.*',
                '{{forms}}.name as name',
                '{{forms}}.email as email'
            ])
            ->joinWith(['lastForm'])
            ->where(['client.id' => $id])
            ->one();

        if (!$client) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('info',
            compact('client')
        );
    }

    /**
     * Show calling list.
     *
     * @param bool|string $partner
     * @param bool|string $office
     * @param bool|string $user
     *
     * @return string
     */
    public function actionRingeliste($partner = false, $office = false, $user = false)
    {
        return $this->render('calling_list',
            compact('partner', 'office', 'user')
        );
    }

    /**
     * Update Client
     * Updates client from request params
     * @return string|HTML
     */
    public function actionUpdateClient($id = false)
    {
        $lead = false;
        if ($id) {
            $lead = Forms::findOne(['id' => $id]);
            $client = $lead->client;
            if ($client->load(Yii::$app->request->post()) && $client->validate()) {
                // Save if valid
                $client->save();
            }
        }
        if (!$lead) {
            // Create empty models if there is no such model
            $lead = new Forms();
            $client = new Client();
        }
        return $this->render('_form', [
            'lead' => $lead,
            'client' => $client,

        ]);
    }

    /**
     * Display a listing of the boligvarsling leads.
     *
     * @return string
     */
    public function actionBoligvarsling()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $boligvarslings = Boligvarsling::find()
                ->filterWhere([
                    'email' => Yii::$app->request->post('email')
                ])
                ->all();

            return $this->renderAjax('boligvarsling_detail', compact('boligvarslings'));
        }

        return $this->render('boligvarsling');
    }

    public function actionBoligvarslingEdit($id)
    {
        $lead = Boligvarsling::find()->with('property')
            ->where(compact('id'))
            ->one();

        if (!$lead) {
            throw new HttpException(404, 'Boligvarsling Not found');
        }

        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = [
                'region' => null,
                'rooms' => null,
                'criterions' => null,
                'property_id' => null,
                'updated_at' => new Expression('NOW()')
            ];

            foreach (Yii::$app->request->post('Boligvarsling') as $key => $val) {
                if (is_array($val)) {
                    $val = Json::encode($val);
                }

                $data[$key] = $val;
            }

            $lead->updateAttributes($data);

            return [
                'success' => true,
                'message' => 'Boligvarsling has been updated.'
            ];
        }

        $types = PropertyDetails::find()
            ->getTypes()
            ->asArray()
            ->all();

        if ($checked = Json::decode($lead->property_type)) {
            foreach ($types as $type => $params) {
                if (in_array($type, $checked)) {
                    $types[$type]['checked'] = true;
                }
            }

            if (in_array('Tomt', $checked) || in_array('Hytte-tomt', $checked)) {
                $types['Alle Tomt']['checked'] = true;
            }
        }

        $areas = PropertyDetails::find()->getAreas()['areas'];

        if ($checked = Json::decode($lead->region)) {
            foreach ($checked as $area => $children) {
                if (!isset($areas[$area])) {
                    continue;
                }

                $areas[$area]['checked'] = true;

                if (is_array($children)) {
                    foreach ($children as $child) {
                        if (isset($areas[$area]['area'][$child])) {
                            $areas[$area]['area'][$child]['checked'] = true;
                        }
                    }
                }
            }
        }

        return $this->render('boligvarsling_edit',
            compact('lead', 'types', 'areas')
        );
    }
}
