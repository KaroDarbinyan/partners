<?php

namespace frontend\controllers;

use common\models\Department;
use common\models\Forms;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

final class DepartmentController extends Controller
{
    /**
     * Show warranty page.
     *
     * @param $slug
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionWarranty($slug)
    {
        $department = $this->findOrFail(['url' => $slug]);

        \Yii::$app->view->params['page'] = 'hvilepuls';
        \Yii::$app->view->title = 'Hvilepulsgaranti';

        $formModel = new Forms;

        return $this->render('/landing/warranty',
            compact('department', 'formModel')
        );
    }

    /**
     * Show sell page.
     *
     * @param $slug
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSell($slug)
    {
        $department = $this->findOrFail(['url' => $slug]);

        \Yii::$app->view->params['page'] = 'selge-bolig';
        \Yii::$app->view->title = 'Selge bolig';

        $formModel = new Forms;

        return $this->render('/landing/sell',
            compact('department', 'formModel')
        );
    }

    /**
     * Find department by condition.
     *
     * @param $condition
     *
     * @return Department
     *
     * @throws NotFoundHttpException
     */
    private function findOrFail($condition)
    {
        $department = Department::find()
            ->filterWhere($condition)
            ->one();

        if (!$department) {
            throw new NotFoundHttpException(
                \Yii::t('app', 'The requested page does not exist.')
            );
        }

        return $department;
    }
}