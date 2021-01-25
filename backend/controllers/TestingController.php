<?php

namespace backend\controllers;

use common\models\Forms;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class TestingController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = Forms::find()
            ->joinWith(['postNumber', 'propertyDetails'], false);
        $count = $dataProvider->count();
        $dataProvider = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => false,
        ]);
        return $this->render('index', compact('dataProvider'));
    }


    public function actionUsers()
    {
        return $this->render('users/list');
    }

}
