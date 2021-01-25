<?php

namespace backend\controllers;

use common\models\Department;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SettingsController extends RoleController
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
     * Displays Settings page .
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        /** @var User $director */
        $director = Yii::$app->user->identity;
        $brokers = User::find()
            ->select(['navn', 'web_id'])
            ->where(['department_id'=>$director->department_id])
            ->asArray()
            ->indexBy('web_id')
            ->all();
        ;
        foreach ($brokers as $id=>$broker) {
            $brokers[$id] = $broker['navn'];
        }
        $dep = $director->department;
        return $this->render('index', compact('brokers', 'dep'));
    }

}
