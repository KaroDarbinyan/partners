<?php
/**
 * Created by PhpStorm.
 * User: FSW10
 * Date: 14.03.2019
 * Time: 14:30
 */

namespace frontend\controllers;


use common\models\Forms;
use Yii;
use yii\web\Controller;


class SellController extends Controller
{

    public function actionValuation()
    {
        Yii::$app->view->params['page'] = 'verdivurdering';
        Yii::$app->view->title = 'Verdivurdering';
        Yii::$app->view->params['header'] = '<b>VERDIVURDERING</b> AV DITT HJEM';
        $model = new Forms();
        return $this->render('valuation', [
            'model' => $model,
        ]);
    }

    /**
     * Show the etakst page.
     *
     * @return string
     */
    public function actionEtakst()
    {
        Yii::$app->view->params['page'] = 'verdivurdering';
        Yii::$app->view->title = 'Gratis e-takst';
        Yii::$app->view->params['header'] = '<b>GRATIS</b> E-TAKST';

        $model = new Forms();

        return $this->render('valuation', compact('model'));
    }


    public function actionSalesProcess()
    {
        Yii::$app->view->params['page'] = 'salgsprosessen';
        Yii::$app->view->title = 'Salgsprosessen';
        Yii::$app->view->params['header'] = '<b>Salgsprosessen</b>';

        return $this->render('sells-process');
    }

    public function actionPriceOffer()
    {
        Yii::$app->view->params['page'] = 'pristilbud';
        Yii::$app->view->title = 'Pristilbud';
        Yii::$app->view->params['header'] = '<b>PRISTILBUD</b>';

        return $this->render('priceOffer', [
            'model' => new Forms
        ]);
    }

}