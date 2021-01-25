<?php

namespace backend\controllers;

use common\models\DigitalMarketing;

class ForsidenController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionStatistikk($id)
    {
        $model = DigitalMarketing::find()->select(['stats', 'type'])->where(['source_object_id' => 17190135])->asArray()->all();
        return $this->render('statistikk', compact('model'));
    }


    public function actionDigitalMarketsforing()
    {
        return $this->render('digital-marketsforing');
    }

    public function actionDigitalMarketsforing1()
    {
        return $this->render('digital-marketsforing1');
    }


}
