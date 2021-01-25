<?php

namespace api\modules\v1\controllers;

use common\models\Partner;
use common\models\Property;
use common\models\PropertyDetails;
use common\models\Department;
use common\models\Salgssnitt;
use common\models\Budsjett;
use Yii;
use yii\base\Exception;
use yii\filters\ContentNegotiator;
use yii\helpers\FileHelper;
use yii\rest\ActiveController;
use yii\web\Response;
use api\modules\v1\controllers\AuthController;

/**
 * Default controller for the `lead` module
 */
class KonsernSalesController extends ActiveController
{

    public $modelClass = Property::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['delete'], $actions['update'], $actions['create']);
        return $actions;
    }

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [
                    'raw' => Response::FORMAT_RAW,
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        return AuthController::authorize();
    }

    public function actionIndex()
    {
        $partners = Partner::find()->asArray()->all();
        $salgssnitt = Salgssnitt::find()->where(['year' => '2019', 'month' => date('n')])->asArray()->one();
        $month_budget = $salgssnitt['value'] / 100;
        
        $results = [];

        foreach ($partners as $key => $partner) {
            $data = $this->getPropertyDetailsData($partner);
            $budsjett = Budsjett::find()->select([
                "SUM(inntekt) as inntekt",
                "SUM(salg) as salg",
                "SUM(befaringer) as befaringer",
                "AVG(hitrate) as hitrate"
            ])->asArray()->one();
    
            $result = [
                'KonsernId' => $partner['id'],
                'KonsernNavn' => $partner['name'],
                'SalesIncomeYear' => $data['provisjon_year'],
                'SalesIncomeBudgetYear' => $budsjett['inntekt'],
                'SalesIncomeBudgetResultYear' => ($data['provisjon_year'] / $budsjett['inntekt']) * 100,
                'SalesNumberYear' => $data['salg_year'],
                'SalesNumberBudgetYear' => $budsjett['salg'],
                'SalesNumberBudgetResultYear' => ($data['salg_year'] / $budsjett['salg']) * 100,
                'BefaringYear' => $data['befaring_year'],
                'BefaringBudgetYear' => $budsjett['befaringer'],
                'BefaringBudgetResultYear' => ($data['befaring_year'] / $budsjett['befaringer']) * 100,
                'SignedYear' => $data['signeringer_year'],
                'SignedBudgetYear' => ($budsjett['hitrate'] / 100) * $budsjett['befaringer'],
                'SignedBudgetResultYear' => ($data['signeringer_year'] / (($budsjett['hitrate'] / 100) * $budsjett['befaringer'])) * 100,
                'SalesIncomeMonth' => $data['provisjon_month'],
                'SalesIncomeBudgetMonth' => $budsjett['inntekt'] * $month_budget,
                'SalesIncomeBudgetResultMonth' => ($data['provisjon_month'] / ($budsjett['inntekt'] * $month_budget)) * 100,
                'SalesNumberMonth' => $data['salg_month'],
                'SalesNumberBudgetMonth' => $budsjett['salg'] * $month_budget,
                'SalesNumberBudgetResultMonth' => $data['salg_month'] > 0 ? ($data['salg_month'] / ($budsjett['salg'] * $month_budget)) * 100 : 0,
                'BefaringMonth' => $data['befaring_month'],
                'BefaringBudgetMonth' => $budsjett['befaringer'] * $month_budget,
                'BefaringBudgetResultMonth' => $data['befaring_month'] > 0 ? ($data['befaring_month'] / ($budsjett['befaringer'] * $month_budget)) * 100 : 0,
                'SignedMonth' => $data['signeringer_month'],
                'SignedBudgetMonth' => $data['signeringer_year'] * $month_budget,
                'SignedBudgetResultMonth' => ($data['signeringer_month'] / ((($budsjett['hitrate'] / 100) * $budsjett['befaringer']) * $month_budget)) * 100,
            ];

            foreach ($result as $key => &$value) {
                if (is_numeric($value)) {
                    $value = round($value, 4);
                }
            }
    
            $results[] = $result;
        }

        return json_encode($results);
    }

    private function getPropertyDetailsData($partner)
    {
        $y = date('Y');
        $start_year = strtotime('01-01-' . $y);

        $start_month = strtotime('01-' . date('m') . '-' . $y);
        $end_month = strtotime(date('t-m-Y', $start_month));

        $start = strtotime('01-01-' . $y);
        $end = time();

        $arr = PropertyDetails::find()
            ->select([
                "SUM(CASE WHEN UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) BETWEEN {$start_month} AND {$end_month} THEN property_details.bokfortprovisjon ELSE 0 END) AS provisjon_month",
                "SUM(CASE WHEN UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) BETWEEN {$start_year} AND {$end} THEN property_details.bokfortprovisjon ELSE 0 END) AS provisjon_year",
                "COUNT(IF(UNIX_TIMESTAMP(STR_TO_DATE(property_details.befaringsdato, \"%d.%m.%Y\")) BETWEEN {$start_month} AND {$end_month}, 1, null)) AS befaring_month",
                "COUNT(IF(UNIX_TIMESTAMP(STR_TO_DATE(property_details.befaringsdato, \"%d.%m.%Y\")) BETWEEN {$start_year} AND {$end}, 1, null)) AS befaring_year",
                "COUNT(IF(UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) BETWEEN {$start_month} AND {$end_month}, 1, null)) AS salg_month",
                "COUNT(IF(UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) BETWEEN {$start_year} AND {$end}, 1, null)) AS salg_year",
                "COUNT(IF(oppdragsdato BETWEEN {$start_month} AND {$end_month}, 1, null)) AS signeringer_month",
                "COUNT(IF(oppdragsdato BETWEEN {$start_year} AND {$end}, 1, null)) AS signeringer_year",
                "property_details.ansatte1_id",
                "property_details.avdeling_id"
            ])->joinWith(['department' => function($query) use ($partner) {
                $query->joinWith(['partner'])->andWhere(['partner.url' => $partner]);
            }])->asArray()->one();

        return $arr;
    }
}
