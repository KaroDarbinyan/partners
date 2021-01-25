<?php

namespace api\modules\mobile\modules\v1\controllers;


use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Test controller for the `mobile/v1` module
 */
class TestController extends Controller
{

    public $database;

    public function beforeAction($action)
    {
        $this->database = Yii::$app->firebase->database;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [
                    'json' => Response::FORMAT_HTML,
                ],
            ]
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions["index"]);
        return $actions;
    }


    public function actionIndex()
    {
        $reference = $this->database->getReference("eiendom");
        $users = $reference->getValue();
        echo '<pre>';
        print_r($users);
        echo '</pre>';
        die;


    }
}
