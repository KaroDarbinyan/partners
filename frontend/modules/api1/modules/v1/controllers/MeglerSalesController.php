<?php

namespace frontend\modules\api\modules\v1\controllers;

use common\models\User;
use common\models\PropertyDetails;
use common\models\Salgssnitt;
use Yii;
use yii\base\Exception;
use yii\filters\ContentNegotiator;
use yii\helpers\FileHelper;
use yii\rest\ActiveController;
use yii\web\Response;
use Firebase\JWT\JWT;

/**
 * Default controller for the `lead` module
 */
class MeglerSalesController extends ActiveController
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

    public function actionIndex()
    {
        $users = User::find()->with([
            'budsjett' => function ($query) {
                $query->andWhere(['budsjett.year' => date('Y')]);
            },
            'department'
        ])->asArray()->all();

        $salgssnitt = Salgssnitt::find()->where(['year' => '2019', 'month' => date('n')])->asArray()->one();
        $month_budget = $salgssnitt['value'] / 100;
        
        $results = [];

        foreach ($users as $key => $user) if (isset($user['budsjett'])) {
            $data = $this->getPropertyDetailsData($user);

            $result = [
                'MeglerId' => $user['web_id'],
                'AvdelingId' => $user['department']['id_firma'],
                'AvdelingNavn' => $user['department']['navn'],
                'MeglerNavn' => $user['navn'],
                'MeglerBilde' => 'https://partners.no' . $user['urlstandardbilde'],
                'SalesIncomeYear' => $data['provisjon_year'],
                'SalesIncomeBudgetYear' => $user['budsjett']['inntekt'],
                'SalesIncomeBudgetResultYear' => ($data['provisjon_year'] / $user['budsjett']['inntekt']) * 100,
                'SalesNumberYear' => $data['salg_year'],
                'SalesNumberBudgetYear' => $user['budsjett']['salg'],
                'SalesNumberBudgetResultYear' => ($data['salg_year'] / $user['budsjett']['salg']) * 100,
                'BefaringYear' => $data['befaring_year'],
                'BefaringBudgetYear' => $user['budsjett']['befaringer'],
                'BefaringBudgetResultYear' => ($data['befaring_year'] / $user['budsjett']['befaringer']) * 100,
                'SignedYear' => $data['signeringer_year'],
                'SignedBudgetYear' => ($user['budsjett']['hitrate'] / 100) * $user['budsjett']['befaringer'],
                'SignedBudgetResultYear' => ($data['signeringer_year'] / (($user['budsjett']['hitrate'] / 100) * $user['budsjett']['befaringer'])) * 100,
                'SalesIncomeMonth' => $data['provisjon_month'],
                'SalesIncomeBudgetMonth' => $user['budsjett']['inntekt'] * $month_budget,
                'SalesIncomeBudgetResultMonth' => ($data['provisjon_month'] / ($user['budsjett']['inntekt'] * $month_budget)) * 100,
                'SalesNumberMonth' => $data['salg_month'],
                'SalesNumberBudgetMonth' => $user['budsjett']['salg'] * $month_budget,
                'SalesNumberBudgetResultMonth' => $data['salg_month'] > 0 ? ($data['salg_month'] / ($user['budsjett']['salg'] * $month_budget)) * 100 : 0,
                'BefaringMonth' => $data['befaring_month'],
                'BefaringBudgetMonth' => $user['budsjett']['befaringer'] * $month_budget,
                'BefaringBudgetResultMonth' => $data['befaring_month'] > 0 ? ($data['befaring_month'] / ($user['budsjett']['befaringer'] * $month_budget)) * 100 : 0,
                'SignedMonth' => $data['signeringer_month'],
                'SignedBudgetMonth' => $data['signeringer_year'] * $month_budget,
                'SignedBudgetResultMonth' => ($data['signeringer_year'] / ((($user['budsjett']['hitrate'] / 100) * $user['budsjett']['befaringer']) * $month_budget)) * 100,
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

    private function getPropertyDetailsData($user)
    {
        $y = date('Y') - 1;
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
                "COUNT(IF(oppdragsdato BETWEEN {$start} AND {$end}, 1, null)) AS signeringer_month",
                "COUNT(IF(oppdragsdato BETWEEN {$start} AND {$end}, 1, null)) AS signeringer_year",
                "property_details.ansatte1_id",
                "property_details.avdeling_id"
            ])->joinWith(['user'])->andWhere(['user.url' => $user])->asArray()->one();

        return $arr;
    }
}
