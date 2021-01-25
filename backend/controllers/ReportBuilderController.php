<?php

namespace backend\controllers;

use backend\assets\AmChartAsset;
use backend\components\UrlExtended;
use common\models\Department;
use common\models\Forms;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\View;

/**
 * Chart controller
 */
class ReportBuilderController extends RoleController
{

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
     * @return array|string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $filter = Yii::$app->request->get();
            $function = $filter['chartType'];
            return $this->$function($filter['query']);
        }

        $deps = Department::find()
            ->select(['department.short_name', 'department.url', 'department.web_id'
            ])->joinWith(['users' => function (ActiveQuery $user) {
                $user->select(['user.navn', 'user.url', 'user.department_id'])->where(['user.inaktiv_status' => 1]);
            }])->where(['department.inaktiv' => 0])->indexBy('url')->asArray()->all();

        return $this->render('index', [
            'deps' => json_encode($deps)
        ]);
    }

    /**
     * Simple Column Chart
     * @param $filter
     * @return string|array|Department[]
     */
    private function simpleColumnChart($filter)
    {
        $dep = [];
        $departments = Department::find()->joinWith([
            'forms' => function (ActiveQuery $forms) {
                $forms->addSelect(['forms.department_id', 'forms.broker_id'])
                    ->andWhere(['in', 'forms.type', Forms::getHotTypes()]);
            }
        ]);

        $exec = isset($filter['where']['department']) ? 'one' : 'all';
        foreach ($filter as $key => $item) {
            if ($key === 'where') {
                $departments->joinWith(['users' => function (ActiveQuery $user) {
                    $user->select([
                        'user.navn as parent_name', 'user.department_id', 'user.web_id', 'user.id', "COALESCE(0) AS parent_count"
                    ])->indexBy('web_id')
                        ->where(['user.inaktiv_status' => 1]);
                }]);
                foreach ($item as $k => $v) {
                    $departments->andWhere(["{$k}.{$v[1]}" => $v[2]]);
                }
            } elseif ($key === 'between') {
                $departments->andWhere(["between", "forms.updated_at", $item['startDate'], $item['endDate']]);
            }
        }
        $departments = $departments->asArray()->$exec();

        if (!$departments) {
            return "error";
        } else if (isset($filter['where']['department'])) {
            $departments['users'][$departments['web_id']] = [
                'parent_name' => 'Ufordelt',
                'parent_count' => 0
            ];
            $dep = $departments['users'];
            foreach ($departments['forms'] as $form) {
                if (array_key_exists($form['broker_id'], $dep)) $dep[$form['broker_id']]['parent_count'] += 1;
                else $dep[$departments['web_id']]['parent_count'] += 1;
            }
        } else {
            foreach ($departments as $department) {
                $dep[] = [
                    'parent_name' => $department['short_name'],
                    'parent_count' => count($department['forms'])
                ];
            }
        }
        ArrayHelper::multisort($dep, 'parent_name');
        return $dep;
    }


    /**
     * Stacked Area Chart
     * @param $filter
     * @return string|array|Department[]
     */
    private function stackedAreaChart($filter)
    {
        if (isset($filter['where']['department'])) {
            return $this->stackedAreaChartForDepartment($filter);
        }
        $deps = Department::find()->select(['web_id', 'short_name'])->where(['inaktiv' => 0])->asArray()->all();
        foreach ($deps as $key => $value) {
            $deps[$key] = "COUNT(if(forms.department_id = {$value['web_id']}, 1, null)) as `" . str_replace(' ', '-', $value['short_name']) . "`";
        }
        array_push($deps,
            'substring(FROM_UNIXTIME(forms.created_at,"%d.%m.%Y"),7,4) as `year`',
            'substring(FROM_UNIXTIME(forms.created_at, "%d.%m.%Y"),4,2) as `month`',
            'substring(FROM_UNIXTIME(forms.created_at, "%Y%m"),1,8) as `step`',
            "forms.department_id");


        $props = Forms::find()->select([implode(', ', $deps)])->joinWith([
            'department' => function (ActiveQuery $dep) {
                $dep->select(['department.web_id', 'department.short_name']);
            }
        ]);

        $props = $this->queryBuilder($props, $filter)->asArray()->all();

        foreach ($props as $k => $v) {
            unset($props[$k]['department'], $props[$k]['department_id']);
        }

        return $props;
    }


    /**
     * Stacked Area Chart
     * @param $filter
     * @return string|array|Department[]
     */
    private function stackedAreaChartForDepartment($filter)
    {

        $deps = Department::find()->select(['department.web_id', 'department.short_name'])
            ->joinWith(['users'])
            ->where(['department.inaktiv' => 0, 'department.url' => $filter['where']['department'][2], 'user.inaktiv_status' => 1])
            ->asArray()->one()['users'];


        foreach ($deps as $key => $value) {
            $deps[$key] = "COUNT(if(forms.broker_id = {$value['web_id']}, 1, null)) as `{$value['short_name']}`";
        }
        array_push($deps,
            'substring(FROM_UNIXTIME(forms.created_at,"%d.%m.%Y"),7,4) as `year`',
            'substring(FROM_UNIXTIME(forms.created_at, "%d.%m.%Y"),4,2) as `month`',
            'substring(FROM_UNIXTIME(forms.created_at, "%Y%m"),1,8) as `step`',
            "forms.department_id", "forms.broker_id");


        $props = Forms::find()->select([implode(', ', $deps)])->joinWith(['user',
            'department' => function (ActiveQuery $dep) {
                $dep->select(['department.web_id', 'department.short_name']);
            }
        ]);


        $props = $this->queryBuilder($props, $filter)->asArray()->all();

        foreach ($props as $k => $v) {
            unset($props[$k]['department_id'], $props[$k]['broker_id'], $props[$k]['user'], $props[$k]['department']);
        }

        return $props;
    }


    /**
     * Date Based Data Chart
     * @param $filter
     * @return string|array|Department[]
     */
    private function dateBasedDataChart($filter)
    {
        $props = Forms::find()->select([
            'substring(FROM_UNIXTIME(forms.created_at,"%d.%m.%Y"),7,4) as `year`',
            'substring(FROM_UNIXTIME(forms.created_at, "%d.%m.%Y"),4,2) as `month`',
            'substring(FROM_UNIXTIME(forms.created_at, "%d.%m.%Y"),1,2) as `day`',
            'FROM_UNIXTIME(forms.created_at, "%Y-%m-%d") as `date`',
            'COUNT(forms.id) as value',
            "forms.department_id"
        ])->joinWith(['department']);
//            ->groupBy(['year', 'month'])->orderBy(['year' => SORT_ASC])
        $props = $this->queryBuilder($props, $filter)->asArray()->all();

        foreach ($props as $k => $v) {
            unset(
                $props[$k]['year'],
                $props[$k]['month'],
                $props[$k]['day'],
                $props[$k]['department_id'],
                $props[$k]['department']
            );
        }

        return $props;
    }


    /**
     * Pie Chart
     * @param $filter
     * @return string|array|Department[]
     */
    private function pieChart($filter)
    {

        $dep = [];
        $departments = Department::find()
            ->joinWith(['users', 'forms' => function (ActiveQuery $forms) {
                $forms->addSelect(['forms.type', 'forms.department_id', 'forms.id', 'forms.broker_id', 'forms.status'])
//                    ->andWhere(['forms.type' => Forms::getHotTypes()])
                ;
            }]);

        $departments = $this->queryBuilder($departments, $filter)->all();

        if (!$departments) {
            return "error";
        } else if (isset($filter['where']['department']) && ($department = $departments[0])) {
            $dep[$department->web_id] = [
                'parent_name' => 'Ufordelt',
                'parent_count' => 0
            ];
            foreach ($department->forms as $form) {
                $user = $form->user;
                if ($user && $user->department_id === $department['web_id']) {
                    if (!isset($dep[$user->id])) {
                        $dep[$user->id] = [
                            'parent_name' => $user->navn,
                            'parent_count' => 0
                        ];
                    }
                    $dep[$user->id]['parent_count'] += 1;
                } else {
                    if ($form->status === 'ufordelt') {
                        $dep[$department['web_id']]['parent_count'] += 1;
                    }
                }
            }
            ArrayHelper::multisort($dep, 'parent_count');

        } else {
            foreach ($departments as $department) {
                $dep[$department['web_id']] = [
                    'parent_name' => $department['short_name'],
                    'parent_count' => count($department['forms'])
                ];

                if ($dep[$department['web_id']]['parent_count'] < 1) {
                    unset($dep[$department['web_id']]);
                }
            }

            ArrayHelper::multisort($dep, 'parent_count');

        }
        return $dep;
    }


    private function queryBuilder(ActiveQuery $query, $filter): ActiveQuery
    {
        $where = $filter["where"];

        foreach ($where as $key => $item) {
            if ($key === "like" || $key === "not like") {
                foreach ($item as $column => $search)
                    $query->andWhere([$key, $column, $search]);
            } else if ($key === "in" || $key === "not in") {
                foreach ($item as $column1 => $exist)
                    $query->andWhere([$key, $column1, $exist]);
            } else if ($key === "between") {
                foreach ($item as $column2 => $range)
                    $query->andWhere([$key, $column2, $range['start'], $range['end']]);
            }
        }

        if (isset($filter["rest"])) {
            foreach ($filter["rest"] as $key => $value) {
                $query->$key($value);
            }
        }

        return $query;
    }


}
