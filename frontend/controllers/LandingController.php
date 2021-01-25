<?php

namespace frontend\controllers;

use common\models\Forms;
use common\models\Partner;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

final class LandingController extends Controller
{
    /**
     * @return string
     */
    public function actionSelge()
    {
        Yii::$app->view->params['page'] = 'selge-bolig';
        Yii::$app->view->title = 'Selge bolig';

        $formModel = new Forms;

        return $this->render('sell', compact('formModel'));
    }

    /**
     * @return string
     */
    public function actionHvilepulsgaranti()
    {
        Yii::$app->view->params['page'] = 'hvilepuls';
        Yii::$app->view->title = 'Hvilepulsgaranti';

        $model = new Forms;

        return $this->render('warranty', [
            'formModel' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionHvilepulsgarantiPersonvern()
    {
        Yii::$app->view->params['page'] = 'hvilepulsgaranti-personvern';
        Yii::$app->view->title = 'Hvilepulsgaranti Personvern';

        $model = new Forms();
        $model->type = 'skal_selge';
        $model->referer_source = 'Involve Ads';
        $model->message = 'Kunde ønsker mer info om Hvilepulsgaranti';

        return $this->render('hvilepulsgaranti-personvern', [
            'model' => $model,
        ]);
    }

    public function actionBoligselgerUng()
    {
        // Aursnes & Partners
        if (!$partner = Partner::findOne(2)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        Yii::$app->view->params['page'] = 'boligselgerung';
        Yii::$app->view->title = 'Boligselger Ung';

        $model = new Forms();

        return $this->render('boligselger_ung', compact('partner', 'model'));
    }
}