<?php

namespace backend\controllers;

use backend\components\UrlExtended;
use common\components\StaticMethods;
use common\models\Accounting;
use common\models\Budsjett;
use common\models\Department;
use common\models\Forms;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\PropertyVisits;
use common\models\Salgssnitt;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * Statistikk controller
 */
class StatistikkController extends RoleController
{
    private $partner = false;
    private $office = false;
    private $choosenUser = false;
    private $currentYear;
    private $salgArray = [];

    /** @var bool|User */
    private $user = false;

    private $year = false;

    public function init()
    {
        parent::init();
        $this->year = Yii::$app->request->get('year', range(2015, date('Y')));
        $this->office = Yii::$app->request->get('office');
        $this->partner = Yii::$app->request->get('partner');
        $this->user = Yii::$app->user->identity;
        $this->choosenUser = Yii::$app->request->get('user');
        $this->currentYear = date('Y');
        Yii::$app->view->params['statistikk'] = 'active';
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
                    [
                        'allow' => true,
                        'actions' => ['embed'],
                        'roles' => ['?'],
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays leadspage.
     *
     * @return string
     */
    public function actionSalg()
    {
        Yii::$app->view->params['salg'] = 'active';
        if (Yii::$app->request->isAjax) {
            return json_encode($this->getPropertyDetailsData());
        }
        $data = $this->getSalgForChart();

        $years = (array)$this->year;
        array_push($years, 'budsjett');

        return $this->render('statistik-chart', [
            'data' => json_encode(array_values($data)),
            'years' => json_encode(array_values($years)),
            'propertyDetailsData' => $this->getPropertyDetailsData()
        ]);
    }


    /**
     * @return false|string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBudsjett()
    {
        if ($this->user->hasRole('broker')) {
            return $this->render('//errors/404');
        }

        if (!Yii::$app->request->isAjax) {
            return $this->render('budsjett', [
                'budsjett_table' => $this->getUsers(date('Y'))
            ]);
        }
        $year = date('Y');
        if ($sort = Yii::$app->request->post('sort')) {
            $type = Yii::$app->request->post('type');
            $year = Yii::$app->request->post('year');
            return json_encode($this->getUsers($year, $sort, $type));
        }
        if ($year = Yii::$app->request->post('year')) {
            return json_encode($this->getUsers($year));
        }
        $budsjett_data = ArrayHelper::index(Yii::$app->request->post('budsjett_data'), 'user_id');

        foreach ($budsjett_data as $budsjett) {
            $model = Budsjett::find()->where(['user_id' => $budsjett['user_id'], 'year' => $budsjett['year']])->one();
            if ($model) {
                $model->updateAttributes($budsjett);
                $model->updated_at = time();
                $model->update();
            } else {
                $model = new Budsjett();
                $model->updateAttributes($budsjett);
                $model->avdeling_id = $budsjett['avdeling_id'];
                $model->save();
            }
            $year = $model->year;
        }

        return json_encode($this->getUsers($year));
    }


    /**
     * @param $year
     * @param null $sort
     * @param int $type
     * @return string
     */
    private function getUsers($year, $sort = null, $type = 4)
    {
        $start = strtotime("01/01/{$year}");
        $end = strtotime("12/31/{$year}");

        //Merge: dev->ringeliste
        $users = User::find()
            ->with(['budsjett' => function (ActiveQuery $query) use ($year) {
                $query->where(['year' => $year]);
            }])
            ->where(['inaktiv_status' => -1]);

        if ($this->choosenUser) {
            $users = $users->andWhere(['user.url' => $this->choosenUser]);
        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $users
                ->joinWith('department')
                ->andWhere([
                    'department.partner_id' => $partner->id,
                    'department.inaktiv' => 0
                ]);
        } elseif ($this->office && $this->office !== Yii::$app->user->identity->url) {
            $users = $users->joinWith(['department'])->andWhere(['department.url' => $this->office]);
        }
        $users = $users
            ->andWhere(['<>', 'user.inaktiv_status', 0])
            ->andWhere(['or',
                ['and',
                    ['>=', 'user.recruitdate', $start],
                    ['<=', 'user.recruitdate', $end]
                ],
                ['and',
                    ['or',
                        ['>=', 'user.dismissaldate', $start],
                        ['user.dismissaldate' => null]],
                    ['<=', 'user.recruitdate', $end]
                ],
            ])
            ->all();

        if ($sort) {
            ArrayHelper::multisort($users, $sort, intval($type));
        }
        return $this->renderPartial('_budsjett-table', compact('users'));
    }


    /**
     * @return false|string
     */
    public function actionBefaringer()
    {
        Yii::$app->view->params['befaringer'] = 'active';
        if (Yii::$app->request->isAjax) {
            return json_encode($this->getPropertyDetailsData());
        }
        $data = $this->generateArray();
        $properties = PropertyDetails::find()
            ->select([
                'property_details.befaringsdato as date',
                'substring(property_details.befaringsdato,7,4) as year',
                'substring(property_details.befaringsdato,4,2) as month',
                'substring(property_details.befaringsdato,1,2) as day',
                'COUNT(property_details.id) as count',
                'property_details.ansatte1_id', 'property_details.avdeling_id'
            ])->joinWith(['user', 'department'])
            ->where(['in', 'substring(property_details.befaringsdato,7,4)', $this->year]);

        if ($this->choosenUser) {
            $user = User::findOne(['url' => $this->choosenUser]);
            $properties = $properties->andWhere(['user.url' => $user->url]);
            $plans = $user->getBudsjetts([$this->currentYear]);
        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $properties->andWhere([
                'department.partner_id' => $partner->id
            ]);

            $plans = $partner->getDepartmentsBudget([$this->currentYear]);
        } elseif ($this->office) {
            $department = Department::findOne(['url' => $this->office]);
            $properties = $properties->andWhere(['department.url' => $department->url]);
            $plans = $department->getBudsjetts([$this->currentYear]);
        } else {
            $plans = Budsjett::getBudsjettsByYear([$this->currentYear]);
        }

        $properties = $properties
            ->orderBy(['year' => SORT_DESC])
            ->groupBy(['year', 'month'])
            ->asArray()
            ->all();

        $salgssnitt = Salgssnitt::getAllYears()[$this->currentYear];
        $i = 1;

        foreach ($properties as $key => $property) {
            $data[$property['month']][$property['year']] = $property['count'];
        }

        foreach ($data as $key => $val) {
            $data[$key]['budsjett'] = ceil($plans['befaringer'] / 100 * $salgssnitt[$i]);
            $i++;
        }

        $years = (array)$this->year;
        array_push($years, 'budsjett');

        return $this->render('statistik-chart', [
            'data' => json_encode(array_values($data)),
            'years' => json_encode(array_values($years)),
            'propertyDetailsData' => $this->getPropertyDetailsData()
        ]);
    }


    /**
     * @return false|string
     */
    public function actionSigneringer()
    {
        Yii::$app->view->params['signeringer'] = 'active';
        if (Yii::$app->request->isAjax) {
            return json_encode($this->getPropertyDetailsData());
        }
        $data = $this->generateArray();
        $properties = PropertyDetails::find()
            ->select([
                'property_details.oppdragsdato as date',
                'substring(FROM_UNIXTIME(oppdragsdato,"%d.%m.%Y"),7,4) as year',
                'substring(FROM_UNIXTIME(oppdragsdato,"%d.%m.%Y"),4,2) as month',
                'substring(FROM_UNIXTIME(oppdragsdato,"%d.%m.%Y"),1,2) as day',
                'COUNT(property_details.id) as count',
                'property_details.avdeling_id', 'property_details.ansatte1_id'
            ])->joinWith(['user', 'department'])
            ->where(['in', 'substring(FROM_UNIXTIME(oppdragsdato,"%d.%m.%Y"),7,4)', $this->year, 'and', 'property_details.oppdragsnummer', 'is not null']);

        if ($this->choosenUser) {
            $properties = $properties->andWhere(['user.url' => $this->choosenUser]);
        } elseif ($partner = Yii::$app->partnerService->selected()) {
            $properties->andWhere([
                'department.partner_id' => $partner->id
            ]);
        } elseif ($this->office) {
            $properties = $properties->andWhere(['department.url' => $this->office]);
        }

        $properties = $properties
            ->orderBy(['year' => SORT_DESC])
            ->groupBy(['year', 'month'])
            ->asArray()
            ->all();

        foreach ($properties as $key => $property) {
            $data[$property['month']][$property['year']] = $property['count'];
        }

        return $this->render('statistik-chart', [
            'data' => json_encode(array_values($data)),
            'years' => json_encode(array_values((array)$this->year)),
            'propertyDetailsData' => $this->getPropertyDetailsData()
        ]);
    }


    /**
     * @return false|string
     */
    public function actionProvisjon()
    {
        Yii::$app->view->params['provisjon'] = 'active';
        if (Yii::$app->request->isAjax) {
            return json_encode($this->getPropertyDetailsData());
        }
        $data = $this->generateArray();
        $years = range(2018, date('Y'));

        $properties = Accounting::find()
            ->select([
                'accounting.id_avdelinger', 'accounting.id_ansatte',
                'FROM_UNIXTIME(accounting.bilagsdato, "%Y") as year',
                'FROM_UNIXTIME(accounting.bilagsdato, "%m") as month',
                'FROM_UNIXTIME(accounting.bilagsdato, "%d") as day',
                'SUM(ABS(accounting.belop)) as sum'
            ])
            ->joinWith(['user', 'department'])
            ->where(['in', 'FROM_UNIXTIME(accounting.bilagsdato, "%Y")', $years])
            ->filter();

        $condition = ["db_id" => [343, 233], "konto" => [3000, 3030, 3120]];

        if ($this->choosenUser) {

            $user = User::findOne(['url' => $this->choosenUser]);
            $properties->andWhere(['user.url' => $user->url]);
            $plans = $user->getBudsjetts([$this->currentYear]);

        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $properties->andWhere(['department.partner_id' => $partner->id]);

            $plans = $partner->getDepartmentsBudget([$this->currentYear]);

            if (intval($partner->id) === 1) $condition = ["db_id" => 343, "konto" => [3000, 3030, 3120]];
            else if ($partner->id && intval($partner->id) !== 1) $condition = ["db_id" => 233, "konto" => [3000, 3030, 3120]];

        } elseif ($this->office) {

            $department = Department::findOne(['url' => $this->office]);
            $properties->andWhere(['department.url' => $department->url]);
            $plans = $department->getBudsjetts([$this->currentYear]);

        } else {
            $plans = Budsjett::getBudsjettsByYear([$this->currentYear]);
        }

        $properties = $properties->andWhere(["accounting.db_id" => $condition["db_id"]])
            ->andWhere(["accounting.konto" => $condition["konto"]]);

        $properties = $properties
            ->orderBy(['year' => SORT_DESC])
            ->groupBy(['year', 'month'])
            ->asArray();

        if (Yii::$app->request->get("print") === "sql") {
            echo '<pre>';
            print_r($properties->createCommand()->rawSql);
            echo '</pre>';
            die;
        }

        $properties = $properties->all();

        $salgssnitt = Salgssnitt::getAllYears()[$this->currentYear];
        $i = 1;

        foreach ($properties as $key => $property) {
            $data[$property['month']][$property['year']] = floor($property['sum']);
        }

        foreach ($data as $key => $val) {
            $data[$key]['budsjett'] = ceil($plans['inntekt'] / 100 * $salgssnitt[$i]);
            $i++;
        }
        array_push($years, 'budsjett');

        return $this->render('statistik-chart', [
            'data' => json_encode(array_values($data)),
            'years' => json_encode(array_values($years)),
            'propertyDetailsData' => $this->getPropertyDetailsData()
        ]);
    }

    /**
     * @return false|string
     */
    public function actionAktiviteter()
    {
        Yii::$app->view->params['aktiviteter'] = 'active';
        if (Yii::$app->request->isAjax) {
            return json_encode($this->getPropertyDetailsData());
        }

        $this->getSalgForChart();
        $befaring = $this->getBefaringForChart();
        $visits = $this->getVisitsForChart();

        $data = (count($this->salgArray) > count($befaring))
            ? StaticMethods::statistikkArrayMix($this->salgArray, $befaring)
            : StaticMethods::statistikkArrayMix($befaring, $this->salgArray);

        $data = (count($visits) > count($data))
            ? StaticMethods::statistikkArrayMix($visits, $data)
            : StaticMethods::statistikkArrayMix($data, $visits);

        return $this->render('statistik-chart', [
            'data' => json_encode(array_values($data)),
            'years' => json_encode(array_values((array)$this->year)),
            'propertyDetailsData' => $this->getPropertyDetailsData()
        ]);
    }

    /**
     * @return array
     */
    private function generateArray()
    {
        $months = [
            '01' => ['month' => 'Jan'],
            '02' => ['month' => 'Feb'],
            '03' => ['month' => 'Mar'],
            '04' => ['month' => 'Apr'],
            '05' => ['month' => 'May'],
            '06' => ['month' => 'Jun'],
            '07' => ['month' => 'Jul'],
            '08' => ['month' => 'Aug'],
            '09' => ['month' => 'Sep'],
            '10' => ['month' => 'Oct'],
            '11' => ['month' => 'Nov'],
            '12' => ['month' => 'Dec']
        ];

        foreach ($months as $key => $month) {
            $months[$key] = $months[$key] + array_fill_keys((array)$this->year, 0);
        }

        return $months;
    }

    /**
     * @return array|\common\models\PropertyDetailsQuery|ActiveQuery|\yii\db\ActiveRecord|null
     */
    private function getPropertyDetailsData()
    {
        $y = date('Y');
        $start = strtotime('01-01-' . $y);
        $end = time();

        if (Yii::$app->request->isAjax) {
            if ($year = Yii::$app->request->get('year')) {
                $start = strtotime('01-01-' . date($year));
                $end = strtotime('31-12-' . date($year));
            } else {
                $start = strtotime('01-01-2015');
            }
        }
        $arr = PropertyDetails::find()
            ->select([
                "SUM(CASE WHEN UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) between {$start} AND {$end} THEN property_details.salgssum ELSE 0 END) as omsetningsverdi",
                "COUNT(if(UNIX_TIMESTAMP(STR_TO_DATE(property_details.befaringsdato, \"%d.%m.%Y\")) between {$start} AND {$end}, 1, null)) as befaring",
                "COUNT(If(UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) between {$start} AND {$end}, 1, null)) as salg",
                "COUNT(if(oppdragsdato between {$start} AND {$end}, 1, null)) as signeringer",
                "property_details.ansatte1_id", "property_details.avdeling_id"
            ])->joinWith(['user', 'department']);

        $provisjon = Accounting::find()
            ->select([
                'accounting.id_avdelinger', 'accounting.id_ansatte',
                "SUM(ABS(accounting.belop)) as provisjon_tilrettelegging"
            ])->joinWith(['user', 'department'])->filter()
            ->andWhere(['between', 'accounting.bilagsdato', $start, $end]);

        $condition = ["db_id" => [343, 233], "konto" => [3000, 3030, 3120]];

        if ($this->choosenUser) {

            $user = User::findOne(['url' => $this->choosenUser]);
            $provisjon = $provisjon->andWhere(['user.url' => $user->url]);
            $arr = $arr->andWhere(['user.url' => $user->url]);

        } elseif ($partner = Yii::$app->partnerService->selected()) {

            $arr = $arr->andWhere(['department.partner_id' => $partner->id]);
            $provisjon = $provisjon->andWhere(['department.partner_id' => $partner->id]);

            if (intval($partner->id) === 1) $condition = ["db_id" => 343, "konto" => [3000, 3030, 3120]];
            else if ($partner->id && intval($partner->id) !== 1) $condition = ["db_id" => 233, "konto" => [3000, 3030, 3120]];

        } elseif ($this->office) {
            $department = Department::findOne(['url' => $this->office]);
            $provisjon = $provisjon->andWhere(['department.url' => $department->url]);
            $arr = $arr->andWhere(['department.url' => $department->url]);
        }

        $provisjon = $provisjon->andWhere(["accounting.db_id" => $condition["db_id"]])
            ->andWhere(["accounting.konto" => $condition["konto"]])->asArray()->asArray()->one();

        $arr = $arr->asArray()->one();

        $arr['provisjon_tilrettelegging'] = number_format($provisjon['provisjon_tilrettelegging'], 0, ' ', ' ');
        $arr['omsetningsverdi'] = number_format($arr['omsetningsverdi'], 0, ' ', ' ');
        $arr['signeringer'] = number_format($arr['signeringer'], 0, ' ', ' ');
        $arr['befaring'] = number_format($arr['befaring'], 0, ' ', ' ');
        $arr['salg'] = number_format($arr['salg'], 0, ' ', ' ');
        unset($arr['ansatte1_id'], $arr['avdeling_id'], $arr['user']);

        return $arr;
    }

    /**
     * @return string
     */
    public function actionSalgssnitt()
    {
        // TODO: add to access controll behavior
        if (!$this->user->hasRole('superadmin')) {
            return $this->render('//errors/404');
        }

        $models = Salgssnitt::getAllYears();

        return $this->render('salgssnitt', compact('models'));
    }

    /**
     * @return string
     */
    public function actionClients()
    {
        return $this->render('clients');
    }

    /**
     * @return array
     */
    private function chartOptionInit()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $conditions = false;
        $start = Yii::$app->session->get('date')['start'];
        $end = Yii::$app->session->get('date')['end'];

        if ($this->choosenUser) {
            $this->choosenUser = User::findOne(['url' => $this->choosenUser]);
            $conditions = [
                'user' => $this->choosenUser,
                'where' => [
                    'forms.broker_id' => $this->choosenUser->web_id
                ]
            ];
        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $conditions = [
                'partner' => $partner,
                'where' => ['forms.partner_id' => $partner->id]
            ];
        } elseif ($this->office) {
            $department = Department::find()->where(['url' => $this->office])->one();
            $conditions = [
                'department' => $department,
                'where' => [
                    'forms.department_id' => $department->web_id
                ]
            ];
        }

        return [
            "start" => $start,
            "end" => $end,
            "options" => $conditions
        ];
    }

    /**
     * chart Kilder
     * @param $start
     * @param $end
     * @param $options
     * @return array|null
     */
    private function chart1($start, $end, $options)// temporarily not used
    {
        $server_name = Yii::$app->request->serverName;
        $types = [
            '3rd party' => [
                'eiendomsmegler.no' => ['eiendomsmegler.no'],
                'meglersiden.no' => ['meglersiden.no'],
                'tjenestetorget.no' => ['tjenestetorget.no']
            ],
            'Search engines' => [
                'google' => ['google.com', 'google.ru', 'google.no'],
                'bing' => ['bing.com'],
                'yahoo' => ['yahoo.com'],
                'yandex' => ['yandex.ru']
            ],
            'Social' => [
                'instagram' => ['instagram.com'],
                'facebook' => ['facebook.com', 'fb.com'],
                'twiter' => ['twiter.com'],
                'vk' => ['vk.com', 'vkontakte.com'],
                'telegram' => ['telegram.com'],
                'tumblr' => ['tumblr.com']
            ],
            'Direkte traffikk' => [
                'annonse' => [$server_name . '/annonse/'],
                'solgt' => [$server_name . '/solgt/'],
                'visning' => [$server_name . '/visning/'],
                'ansatte' => [$server_name . '/ansatte/'],
                'office' => [$server_name . '/office/']
            ]
        ];

        foreach ($types as $type) {
            foreach ($type as $k => $v) {
                $types['Rest'][] = implode('|', array_values($v));
            }
        }
        $types['Rest'] = ['all' => [implode('|', $types['Rest'])]];

        $query_template = Forms::find()
            ->andWhere(['not in', 'forms.status', [
                '1013',
                '1003',
                '1020',
                '1017']])
            ->andWhere(['between', 'forms.created_at', $start, $end])
            ->orWhere(['forms.type' => 'budvarsel', 'forms.contact_me' => 1]);
        if ($options) {
            $query_template = $query_template->andWhere($options['where']);
        }

        $forms = [];
        foreach ($types as $key => $value) {
            $data = $key === 'Rest' ? ['not' => 'not ', 'data' => $value] : ['not' => '', 'data' => $value];
            $party = $key === '3rd party' ? ['name' => 'child_nam, forms.type as child_name', 'index' => 1] : ['name' => 'child_name', 'index' => 3];
            $select = $this->generateQuery($data);

            $not_rlike = [];
            foreach ($value as $item) {
                $not_rlike[] = implode('|', $item);
            }
            $form = clone $query_template;

            $form = $form->addSelect($select . " AS {$party['name']}, COUNT(*) AS child_count")
                ->andWhere("forms.referer_source " . $data['not'] . "RLIKE '" . implode('|', $not_rlike) . "'")
                ->groupBy('child_name')->asArray()->all();

            $forms[] = [
                'parent_name' => $key,
                'parent_count' => ArrayHelper::getValue($form, function ($form) {
                    $defaultValue = 0;
                    foreach ($form as $item) $defaultValue += $item['child_count'];
                    return $defaultValue;
                }),
                'childes' => ArrayHelper::getValue($form, function ($form) use ($data, $not_rlike, $key, $party) {
                    foreach ($form as $k => $item) {
                        $str = $key === 'Rest' ? '' : $item['child_name'];
                        $form[$k]['link'] = UrlExtended::toRoute([
                            'clients/hot',
                            'office' => Yii::$app->request->get('office'),
                            'user' => Yii::$app->request->get('user'),
                            'filter' => [$party['index'] => $str]
                        ]);
                    }
                    return $form;
                })
            ];

            if ($forms[count($forms) - 1]['parent_count'] === 0) {
                array_pop($forms);
            }
        }

        $forms = ['type' => 'v2', 'data' => $forms];
        return $forms['data'] ? $forms : null;
    }

    /**
     * chart 3RD PARTY BY SOURCE
     * @return array|Forms[]
     */
    public function action3rdPartyBySource()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];


        $types = [
            'eiendomsmegler.no',
            'meglersiden.no',
            'tjenestetorget.no'
        ];

        $forms = Forms::find()
            ->select(['count(forms.id) as child_count', 'forms.referer_source as child_name'])
            ->andWhere(['not in', 'forms.status', [
                '1013',
                '1003',
                '1020',
                '1017']])
            ->andWhere(['in', 'forms.type', Forms::getHotTypes()])
            ->andWhere(['RLIKE ', 'forms.referer_source', implode('|', $types)])
            ->andWhere(['between', 'forms.created_at', $start, $end]);
        if ($options) {
            $forms = $forms->andWhere($options['where']);
        } else {
            $forms = $forms->andWhere(['not', ['forms.department_id' => null]]);
        }
        $forms = $forms->groupBy(['forms.referer_source'])->asArray()->all();

        $arr = null;
        foreach ($forms as $form) {
            if ($form['child_count'] > 0) {
                $form['child_name'] = strtolower(str_replace(['https://', 'http://', '/'], '', $form['child_name']));
                $arr['data'][] = [
                    'child_name' => $form['child_name'],
                    'child_count' => $form['child_count'],
                    'link' => UrlExtended::toRoute([
                        'clients/hot',
                        'office' => Yii::$app->request->get('office'),
                        'user' => Yii::$app->request->get('user'),
                        'filter' => [7 => $form['child_name']],
                    ])
                ];
            }
        }

        return $arr['data'] ? ['type' => 'v1', 'data' => $arr['data']] : null;
    }

    /**
     * chart 3RD PARTY BY OFFICE
     * @return array|Department[]
     */
    public function action3rdPartyByOffice()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];

        $types = [
            'eiendomsmegler.no',
            'meglersiden.no',
            'tjenestetorget.no'
        ];
        $dep = [];
        $departments = Department::find()
            ->joinWith(['forms' => function (ActiveQuery $forms) use ($start, $end, $types) {
                $forms->addSelect(['forms.referer_source', 'forms.department_id', 'forms.id', 'forms.broker_id', 'forms.status'])
                    ->andWhere(['not in', 'forms.status', [
                        '1013',
                        '1003',
                        '1020',
                        '1017']])
                    ->andWhere(['in', 'forms.type', Forms::getHotTypes()])
                    ->andWhere(['RLIKE ', 'forms.referer_source', implode('|', $types)])
                    ->andWhere(['between', 'forms.created_at', $start, $end]);
            }]);
        if ($options) {
            $departments = $departments->andWhere($options['where']);
        } else {
            $departments = $departments->andWhere(['not', ['forms.department_id' => null]]);
        }
        $departments = $departments->all();

        if (count($departments) < 1) {
            return null;
        }

        foreach ($departments as $department) {
            $dep[$department['web_id']] = [
                'parent_name' => $department['short_name'],
                'partner' => $department->partner,
                'department' => $department,
                'parent_link' => $department["url"],
                'parent_count' => 0,
                'childes' => [
                    $department->web_id => [
                        'child_name' => 'Ufordelt',
                        'child_link' => '',
                        'child_count' => 0,
                        'link' => UrlExtended::toRoute([
                            'clients/hot',
                            'office' => $department->url,
                            'filter' => [7 => 'ufordelt'],
                        ])
                    ]
                ]
            ];

            /** @var User $user */
            /** @var Forms $form */
            foreach ($department->forms as $form) {
                $user = $form->user;
                if ($user && $user->id_avdelinger === $department->web_id) {
                    if (!isset($dep[$department->web_id]['childes'][$user->id])) {
                        $dep[$department->web_id]['childes'][$user->id] = [
                            'child_name' => $user->navn,
                            'child_link' => $user->url,
                            'child_count' => 0,
                            'link' => Yii::$app->urlManager->createUrl([
                                'clients/hot',
                                'user' => $user->url,
                                'filter' => [7 => join(', ', $types)]
                            ])
                        ];
                    }
                    $dep[$department->web_id]['childes'][$user->id]['child_count'] += 1;
                } else {
                    if ($form->status === 'ufordelt') {
                        $dep[$department->web_id]['childes'][$department->web_id]['child_count'] += 1;
                    }
                }
                $dep[$department->web_id]['parent_count'] += 1;
            }
            if ($dep[$department->web_id]['childes'][$department->web_id]['child_count'] < 1) {
                unset($dep[$department->web_id]['childes'][$department->web_id]);
            }
            if ($dep[$department->web_id]['parent_count'] < 1) {
                unset($dep[$department->web_id]);
            } else {
                ArrayHelper::multisort($dep[$department->web_id]['childes'], 'child_count');
            }
        }

        if (isset($options["partner"])) {
            $dep = ['type' => 'v2', 'data' => $dep];
        } else if (isset($options["department"])) {
            $dep = ['type' => 'v1', 'data' => $dep[$options["department"]["web_id"]]['childes']];
        } else if (isset($options["user"])) {
            $dep = ['type' => 'v1', 'data' => $dep[$options["user"]["id_avdelinger"]]['childes']];
        } else {
            $prts = [];
            foreach ($dep as $item) {
                if (!array_key_exists($item["partner"]["id"], $prts)) {
                    $prts[$item["partner"]["id"]] = [
                        "parent_name" => $item["partner"]["name"],
                        "parent_count" => 0,
                        "childes" => []
                    ];
                }
                $prts[$item["partner"]["id"]]["parent_count"] += $item["parent_count"];
                $prts[$item["partner"]["id"]]["childes"][] = [
                    "child_name" => $item["parent_name"],
                    "child_count" => $item["parent_count"],
                    "link" => UrlExtended::toRoute([
                        'clients/hot',
                        'office' => $item["parent_link"],
                        'filter' => [7 => join(', ', $types)]
                    ])
                ];
            }
            $dep = ['type' => 'v2', 'data' => $prts];
        }


//        $dep = $options ? ['type' => 'v1', 'data' => $dep[$department->web_id]['childes']] : ['type' => 'v2', 'data' => $dep];

        ArrayHelper::multisort($dep['data'], 'child_count');

        return $dep['data'] ? $dep : null;
    }

    /**
     * chart Hot clients by source
     * @return array|Forms[]
     */
    public function actionHotClientsBySource()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];

        $sources = [
            'eiendomsmegler.no',
            'meglersiden.no',
            'tjenestetorget.no'
        ];

        $hotTypes = Forms::getHotTypes();
        if (($key = array_search("book_visning", $hotTypes)) !== false) unset($hotTypes[$key]);

        $form = Forms::find()
            ->select(['count(forms.id) as child_count'])
            //Merge: dev-local -> ringeliste
            ->andWhere(['not in', 'forms.status', [
                '1013',
                '1003',
                '1020',
                '1017'
            ]])
            ->andWhere(['in', 'forms.type', $hotTypes])
            ->andWhere(['not RLIKE ', 'forms.referer_source', implode('|', $sources)])
            ->andWhere(['between', 'forms.created_at', $start, $end]);

        if ($options) {
            $form = $form->andWhere($options['where']);
        } else {
            $form = $form->andWhere(['not', ['forms.department_id' => null]]);
        }
        $form = $form
            ->asArray()->all();

        foreach ($form as $k => $v) {
            if ($form[$k]['child_count'] > 0) {
                $form[$k]['link'] = UrlExtended::toRoute([
                    'clients/hot',
                    'office' => Yii::$app->request->get('office'),
                    'user' => Yii::$app->request->get('user'),
                    'filter' => [1 => "Our own"]
                ]);
                $form[$k]["child_name"] = "Our own";
            } else {
                unset($form[$k]);
            }
        }

        if ($party = $this->action3rdPartyBySource()) {
            $form[] = [
                'child_count' => ArrayHelper::getValue($party, function ($party) {
                    $defaultValue = 0;
                    foreach ($party['data'] as $item) $defaultValue += $item['child_count'];
                    return $defaultValue;
                }),
                'child_name' => '3rd party',
                "link" => UrlExtended::toRoute([
                    'clients/hot',
                    'office' => Yii::$app->request->get('office'),
                    'user' => Yii::$app->request->get('user'),
                    'filter' => [1 => "3rd party"]
                ])
            ];
        }

        $form = ['type' => 'v1', 'data' => $form];
        return $form['data'] ? $form : null;
    }

    /**
     * chart Hot clients
     * @return array|Forms[]
     */
    public function actionHotClients()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];

        $hotTypes = Forms::getHotTypes();
        if (($key = array_search("book_visning", $hotTypes)) !== false) unset($hotTypes[$key]);

        $form = Forms::find()
            ->select(['count(forms.id) as child_count', 'forms.type as child_name'])
            ->andWhere(['not in', 'forms.status', [
                '1013',
                '1003',
                '1020',
                '1017']])
            ->andWhere(['in', 'forms.type', $hotTypes]);
        if ($options) {
            $form = $form->andWhere($options['where']);
        }
        $form = $form
            ->andWhere(['between', 'forms.created_at', $start, $end])
            ->groupBy(['forms.type'])
            ->asArray()->all();

        foreach ($form as $k => $v) {
            $form[$k]['link'] = UrlExtended::toRoute([
                'clients/hot',
                'office' => Yii::$app->request->get('office'),
                'user' => Yii::$app->request->get('user'),
                'filter' => [1 => $v['child_name']]
            ]);
        }

        $form = ['type' => 'v1', 'data' => $form];
        return $form['data'] ? $form : null;
    }

    /**
     * chart Cold clients
     * @return array|Forms[]
     */
    public function actionColdClients()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];

        $form = Forms::find()
            ->select(['count(forms.id) as child_count', 'forms.type as child_name'])
            ->andWhere(['not in', 'forms.status', [
                '1013',
                '1003',
                '1020',
                '1017']])
            ->andWhere(['in', 'forms.type', Forms::getColdTypes()])
            ->andWhere(['not in', 'forms.type', ['selger', 'kjoper', 'boligvarsling']]);
        if ($options) {
            $form = $form->andWhere($options['where']);
        }
        $form = $form
            ->andWhere(['between', 'forms.created_at', $start, $end])
            ->groupBy(['forms.type'])
            ->asArray()->all();

        foreach ($form as $k => $v) {
            $form[$k]['link'] = UrlExtended::toRoute([
                'clients/cold',
                'office' => Yii::$app->request->get('office'),
                'user' => Yii::$app->request->get('user'),
                'filter' => [1 => $v['child_name']]
            ]);
        }

        $form = ['type' => 'v1', 'data' => $form];
        return $form['data'] ? $form : null;
    }

    /**
     * chart Behandlede / Ubehandlede
     * @return array|Forms[]
     */
    public function actionBehandledeUbehandlede()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];

        $types = [
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
        ];
        $in = str_replace(",", "', '", implode(",", $types));

        $forms = Forms::find()
            ->select([
                "COUNT(CASE WHEN forms.status in ('{$in}') THEN 1 END) as Behandlede",
                "COUNT(CASE WHEN forms.status not in ('{$in}') THEN 1 END) as Ubehandlede"
            ])
            ->andWhere(['in', 'forms.type', Forms::getHotTypes()])
            ->andWhere(['between', 'forms.created_at', $start, $end]);
        if ($options) {
            $forms = $forms->andWhere($options['where']);
        }
        $forms = $forms->asArray()->one();

        $arr = null;
        foreach ($forms as $k => $v) {
            if ($v > 0) {
                $arr['data'][] = [
                    'child_name' => $k,
                    'child_count' => $v,
                    'link' => UrlExtended::toRoute([
                        'clients/hot',
                        'office' => Yii::$app->request->get('office'),
                        'user' => Yii::$app->request->get('user'),
                        'filter' => [6 => $k],
                    ])
                ];
            }
        }

        return $arr['data'] ? ['type' => 'v1', 'data' => $arr['data']] : null;
    }

    /**
     * chart Kontorer / Meglere
     * @return array|Department[]
     */
    public function actionKontorerMeglere()
    {
        $attr = $this->chartOptionInit();
        $start = $attr["start"];
        $end = $attr["end"];
        $options = $attr["options"];

        $hotTypes = Forms::getHotTypes();
        if (($key = array_search("book_visning", $hotTypes)) !== false) unset($hotTypes[$key]);

        $dep = [];
        $departments = Department::find()
            ->joinWith(['forms' => function (ActiveQuery $forms) use ($hotTypes, $start, $end) {
                $forms->addSelect(['forms.type', 'forms.department_id', 'forms.id', 'forms.broker_id', 'forms.status'])
                    ->andWhere(['not in', 'forms.status', [
                        '1013',
                        '1003',
                        '1020',
                        '1017']])
                    ->andWhere(['forms.type' => $hotTypes])
                    ->andWhere(['between', 'forms.created_at', $start, $end]);
            }]);
        if ($options) {
            $departments->andWhere($options['where']);
        }
        $departments = $departments->all();

        if (count($departments) < 1) {
            return null;
        }

        foreach ($departments as $department) {
            $dep[$department['web_id']] = [
                'parent_name' => $department['short_name'],
                'partner' => $department->partner,
                'department' => $department,
                'parent_link' => $department["url"],
                'parent_count' => 0,
                'childes' => [
                    $department->web_id => [
                        'child_name' => 'Ufordelt',
                        'child_link' => '',
                        'child_count' => 0,
                        'link' => UrlExtended::toRoute([
                            'clients/hot',
                            'office' => $department->url,
                            'filter' => [5 => 'ufordelt'],
                        ])
                    ]
                ]
            ];

            /** @var User $user */
            /** @var Forms $form */
            foreach ($department->forms as $form) {
                $user = $form->user;
                if ($user && $user->id_avdelinger === $department->web_id) {
                    if (!isset($dep[$department->web_id]['childes'][$user->id])) {
                        $dep[$department->web_id]['childes'][$user->id] = [
                            'child_name' => $user->navn,
                            'child_link' => $user->url,
                            'child_count' => 0,
                            'link' => Yii::$app->urlManager->createUrl(['clients/hot', 'user' => $user->url])
                        ];
                    }
                    $dep[$department->web_id]['childes'][$user->id]['child_count'] += 1;
                    $dep[$department->web_id]['parent_count'] += 1;
                } else {
                    if ($form->status === 'ufordelt') {
                        $dep[$department->web_id]['childes'][$department->web_id]['child_count'] += 1;
                    }
                }
            }
            if ($dep[$department->web_id]['childes'][$department->web_id]['child_count'] < 1) {
                unset($dep[$department->web_id]['childes'][$department->web_id]);
            }
            if ($dep[$department->web_id]['parent_count'] < 1) {
                unset($dep[$department->web_id]);
            } else {
                ArrayHelper::multisort($dep[$department->web_id]['childes'], 'child_count');
            }
        }


        if (isset($options["partner"])) {
            $dep = ['type' => 'v2', 'data' => $dep];
        } else if (isset($options["department"])) {
            $dep = ['type' => 'v1', 'data' => $dep[$options["department"]["web_id"]]['childes']];
        } else if (isset($options["user"])) {
            $dep = ['type' => 'v1', 'data' => $dep[$options["user"]["id_avdelinger"]]['childes']];
        } else {
            $prts = [];
            foreach ($dep as $item) {
                if (!array_key_exists($item["partner"]["id"], $prts)) {
                    $prts[$item["partner"]["id"]] = [
                        "parent_name" => $item["partner"]["name"],
                        "parent_count" => 0,
                        "childes" => []
                    ];
                }
                $prts[$item["partner"]["id"]]["parent_count"] += $item["parent_count"];
                $prts[$item["partner"]["id"]]["childes"][] = [
                    "child_name" => $item["parent_name"],
                    "child_count" => $item["parent_count"],
                    "link" => Yii::$app->urlManager->createUrl(['clients/hot', 'office' => $item["parent_link"]])
                ];
            }
            $dep = ['type' => 'v2', 'data' => $prts];
        }

//        $dep = !isset($options["user"]) ? ['type' => 'v1', 'data' => $dep[$department->web_id]['childes']] : ['type' => 'v2', 'data' => $dep];

        ArrayHelper::multisort($dep['data'], 'child_count');

        return $dep['data'] ? $dep : null;
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEmbed($id)
    {
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
            ->filterWhere(['id' => $id])
            ->orFilterWhere(['oppdragsnummer' => $id])
            ->one();

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

        if ($model->isRelationPopulated('digitalMarketing') && count($model->digitalMarketing)) {
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
        if (Yii::$app->request->get('view') == 'dashboard') {
            $view = 'embed-dashboard';
        } else {
            $view = 'embed';
        }

        $this->view->params['model'] = $model;
        $this->view->params['v'] = 'statistikk';
        return $this->renderPartial($view, compact('model', 'dm'));
    }

    /**
     * @param array $select
     * @return string
     */
    private function generateQuery($select = [])
    {
        $select['not'] = $select['not'] ? 'not R' : '';
        $str = "(CASE";
        foreach ($select['data'] as $key => $value) {
            foreach ($value as $item) {
                $str .= " WHEN forms.referer_source " . $select['not'] . "LIKE '%{$item}%' THEN '{$key}' ";
            }
        }
        return $str . "END)";
    }

    /**
     * @return array
     */
    private function getSalgForChart()
    {
        $data = $this->generateArray();
        $salg = PropertyDetails::find()
            ->select([
                'property_details.akseptdato as date',
                'substring(property_details.akseptdato,7,4) as year',
                'substring(property_details.akseptdato,4,2) as month',
                'substring(property_details.akseptdato,1,2) as day',
                'COUNT(property_details.id) as count',
                'property_details.ansatte1_id', 'property_details.avdeling_id'
            ])->joinWith(['user', 'department'])
            ->where(['and',
                ['in', 'substring(property_details.akseptdato,7,4)', $this->year],
                ['property_details.solgt' => '-1']]);

        if ($this->choosenUser) {
            $user = User::findOne(['url' => $this->choosenUser]);
            $salg->andWhere(['user.url' => $user->url]);
            $plans = $user->getBudsjetts([$this->currentYear]);
        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $salg->andWhere([
                'department.partner_id' => $partner->id
            ]);

            $plans = $partner->getDepartmentsBudget([$this->currentYear]);
        } elseif ($this->office) {
            $department = Department::findOne(['url' => $this->office]);
            $salg->andWhere(['department.url' => $department->url]);
            $plans = $department->getBudsjetts([$this->currentYear]);
        } else {
            $plans = Budsjett::getBudsjettsByYear([$this->currentYear]);
        }
        $salg = $salg
            ->orderBy(['year' => SORT_DESC])
            ->groupBy(['year', 'month'])
            ->asArray()
            ->all();

        $i = 1;
        $salgssnitt = Salgssnitt::getAllYears()[$this->currentYear];
        $this->salgArray = $data;
        foreach ($salg as $key => $property) {
            $data[$property['month']][$property['year']] = $property['count'];
            $this->salgArray[$property['month']][$property['year']] = $property['count'] * 2;
        }

        foreach ($data as $key => $val) {
            $data[$key]['budsjett'] = ceil($plans['salg'] / 100 * $salgssnitt[$i]);
            $i++;
        }
        return $data;
    }

    /**
     * @return array
     */
    private function getBefaringForChart()
    {
        $data = $this->generateArray();
        $befarings = PropertyDetails::find()
            ->select([
                'property_details.befaringsdato as date',
                'substring(property_details.befaringsdato,7,4) as year',
                'substring(property_details.befaringsdato,4,2) as month',
                'substring(property_details.befaringsdato,1,2) as day',
                'COUNT(property_details.id) as count',
                'property_details.ansatte1_id', 'property_details.avdeling_id'
            ])->joinWith(['user', 'department'])
            ->where(['in', 'substring(property_details.befaringsdato,7,4)', $this->year]);

        if ($this->choosenUser) {
            $user = User::findOne(['url' => $this->choosenUser]);
            $befarings->andWhere(['user.url' => $user->url]);
            $plans = $user->getBudsjetts([$this->currentYear]);
        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $befarings->andWhere([
                'department.partner_id' => $partner->id
            ]);

            $plans = $partner->getDepartmentsBudget([$this->currentYear]);
        } elseif ($this->office) {
            $department = Department::findOne(['url' => $this->office]);
            $befarings->andWhere(['department.url' => $department->url]);
            $plans = $department->getBudsjetts([$this->currentYear]);
        } else {
            $plans = Budsjett::getBudsjettsByYear([$this->currentYear]);
        }

        $befarings = $befarings
            ->orderBy(['year' => SORT_DESC])
            ->groupBy(['year', 'month'])
            ->asArray()
            ->all();

        $salgssnitt = Salgssnitt::getAllYears()[$this->currentYear];
        $i = 1;

        foreach ($befarings as $key => $befaring) {
            $data[$befaring['month']][$befaring['year']] = $befaring['count'];
        }

        foreach ($data as $key => $val) {
            $data[$key]['budsjett'] = ceil($plans['befaringer'] / 100 * $salgssnitt[$i]);
            $i++;
        }
        return $data;
    }

    /**
     * @return array
     */
    private function getVisitsForChart()
    {
        $data = $this->generateArray();
        $visits = PropertyVisits::find()->select([
            'property_visits.property_web_id',
            'substring(FROM_UNIXTIME(property_visits.til, "%d.%m.%Y"),7,4) as year',
            'substring(FROM_UNIXTIME(property_visits.til, "%d.%m.%Y"),4,2) as month',
            'substring(FROM_UNIXTIME(property_visits.til, "%d.%m.%Y"),1,2) as day',
            'COUNT(property_visits.id) as count'
        ])->joinWith(['propertyDetail' => function (ActiveQuery $property) {
            $property->addSelect(['property_details.id', 'property_details.ansatte1_id', 'property_details.avdeling_id'])
                ->joinWith(['department', 'user' => function (ActiveQuery $user) {
                    $user->addSelect(['user.id', 'user.navn', 'user.web_id', 'user.tittel', 'user.urlstandardbilde']);
                }]);
        }]);

        if ($this->choosenUser) {
            $visits->andWhere(['user.url' => $this->choosenUser]);
        } /** @var Partner $partner */
        elseif ($partner = Yii::$app->partnerService->selected()) {
            $visits->andWhere([
                'department.partner_id' => $partner->id
            ]);
        } else if ($this->office) {
            $visits->andWhere(['department.url' => $this->office]);
        }

        $visits = $visits
            ->orderBy(['year' => SORT_DESC])
            ->groupBy(['year', 'month'])
            ->asArray()
            ->all();

        foreach ($visits as $key => $visit) {
            $data[$visit['month']][$visit['year']] = $visit['count'];
        }

        return $data;
    }


}
