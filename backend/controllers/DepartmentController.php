<?php

namespace backend\controllers;

use common\models\Department;
use common\models\User;
use Yii;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\Response;

final class DepartmentController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Department
     */
    protected $department;

    /**
     * This method is invoked right before an action is executed.
     *
     * @param Action $action
     *
     * @return bool
     *
     * @throws HttpException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->user = Yii::$app->user->identity;

        if (!$this->user->hasRole(['director', 'partner', 'superadmin'])) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $this->department = Department::find()
            ->with(['user', 'directorDeputy'])
            ->joinWith(['users' => function (ActiveQuery $query) {
                $query
                    ->where(['user.inaktiv_status' => -1])
                    ->andWhere(['not', ['user.web_id' => $this->user->web_id]]);
            }])
            ->where(['department.web_id' => $this->user->id_avdelinger])
            ->one();

        if (!$this->department) {
            return $this->render('//errors/404');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return parent::beforeAction($action);
    }

    public function actionAppointDeputy()
    {
        return $this->render('appoint_deputy', [
            'user' => $this->user,
            'department' => $this->department
        ]);
    }
    public function actionStoreDeputy()
    {
        $userId = Yii::$app->request->post('user_id');

        if (!Yii::$app->request->isAjax || !$userId) {
            return ['success' => false];
        }

        $deputy = User::findOne(['web_id' => $userId]);

        if (!$deputy) {
            return ['success' => false];
        }

        // Department has a deputy.
        if (Yii::$app->request->isPost && $this->department->acting) {
            $user = User::findOne(['web_id' => $this->department->acting]);

            if ($user && $user->hasRole('director')) {
                $user->updateAttributes([
                    'role' => 'broker'
                ]);
            }
        }

        if ($deputy->hasRole(['broker', 'director'])) {
            $deputy->updateAttributes([
                'role' => Yii::$app->request->isPost ? 'director' : 'broker'
            ]);
        }

        $this->department->updateAttributes([
            'avdelingsleder' => Yii::$app->request->isPost ? $deputy->web_id : new Expression('user_id'),
            'acting' => Yii::$app->request->isPost ? $deputy->web_id : 0
        ]);

        return [
            'success' => true,
            'html' => $this->renderAjax('deputy_block', [
                'user' => Yii::$app->request->isPost ? $deputy : null
            ])
        ];
    }
}
