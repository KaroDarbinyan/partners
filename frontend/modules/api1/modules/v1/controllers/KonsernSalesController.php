<?php

namespace frontend\modules\api\modules\v1\controllers;

use common\models\Property;
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
class TestController extends ActiveController
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
        // KonsernID
        // KonsenNavn
        // SalesIncomeYear
        // SalesBudgetYear
        // SalesBudgetResultYear
        // SalesNumberYear
        // SalesNumberBudgetYear
        // SalesNumberBudgetResult
        // BefaringYear
        // BefaringBudgetYear
        // BefaringResultYear
        // SignedYear
        // SignedBudgetYear
        // SignedResultYear
        // SalesIncomeMonth
        // SalesBudgetMonth
        // SalesBudgetResultMonth
        // SalesNumberMonth
        // SalesNumberBudgetMOnth
        // SalesNumberBudgetMonth
        // BefaringMonth
        // BefaringBudgetMonth
        // BefaringResultMonth
        // SignedMonth
        // SignedBudgetMonth
        // SignedResultMonth
        
    }

}
