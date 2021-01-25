<?php

namespace backend\controllers;

use backend\controllers\actions\LeadsArchivesAction;
use common\models\Forms;
use common\models\User;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

final class LeadsController extends RoleController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'archives-data' => LeadsArchivesAction::class,
        ];
    }

    /**
     * Update the lead in storage.
     *
     * @param $id
     *
     * @return string
     */
    public function actionUpdate($id)
    {
        //TODO:: add permition controll
        if (!$lead = Forms::findOne($id)) {
            return Json::encode([
                'success' => false,
                'message' => 'Lead not Found'
            ]);
        }

        foreach (Yii::$app->request->post() as $input => $value) {
            $lead->{$input} = $value;
        }

        return Json::encode([
            'success' => $lead->save(false)
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'contact-phone' => ['POST'],
                    'interested' => ['POST'],
                    'not-interested' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Get the phone from the leads.
     *
     * @return string
     *
     * @throws NotFoundHttpException
     *
     * @throws Throwable
     *
     * @throws StaleObjectException
     */
    public function actionContactPhone()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $lead = $this->findOrFail(Yii::$app->request->post('id'));

        if ($user->web_id !== $lead->request_phone_user_id
            && $lead->request_phone_at
            && $lead->request_phone_at > time()) {
            return Json::encode([
                'success' => false,
                'phone' => '<span class="text-danger">Annen megler jobber med denne</span>',
                'countdown' => $lead->request_phone_at
            ]);
        }

        if (!$lead->request_phone_at || $lead->request_phone_at <= time()) {
            $lead->request_phone_user_id = $user->web_id;
            $lead->request_phone_at = strtotime('+5 minute');

            Forms::updateAll(['request_phone_at' => null], [
                'request_phone_user_id' => $user->web_id
            ]);

            $lead->update(false);
        }

        return Json::encode([
            'success' => true,
            'phone' => $this->renderPartial('_contact_phone', compact('lead')),
            'countdown' => $lead->request_phone_at
        ]);
    }

    /**
     * Get the lead short info.
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionShortInfo()
    {
        $lead = $this->findOrFail(Yii::$app->request->post('id'));

        return Json::encode([
            'html' => $this->renderPartial('_short_info', compact('lead')),
        ]);
    }

    /**
     * Prolong phone request.
     *
     * @return string
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionContactPhoneProlong()
    {
        $lead = $this->findOrFail(Yii::$app->request->post('id'));

        $this->authorize('management', $lead);

        $lead->request_phone_at = strtotime('+2 minute', $lead->request_phone_at);
        $lead->update(false);

        return Json::encode([
            'countdown' => $lead->request_phone_at
        ]);
    }

    /**
     * Store Loggføring form to storage.
     *
     * @return string
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionInterested()
    {
        $request = Yii::$app->request;

        $lead = $this->findOrFail($request->post('id'));

        $this->authorize('management', $lead);

        $lead->addLog(
            $request->post('type'),
            $request->post('message'),
            $request->post('notify_at')
        );

        if (!$lead->broker_id || !$lead->department_id) {
            /** @var User $user */
            $user = Yii::$app->user->identity;

            $lead->department_id = $user->department_id;
            $lead->broker_id = $user->web_id;
        }

        if ($lead->isOwner() && !$lead->favorite) {
            $lead->favorite = $request->post('favorite') === 'on';
        }

        $lead->update(false);

        return Json::encode([
            'success' => true
        ]);
    }

    /**
     * Store Loggføring form to storage.
     *
     * @return string
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionCommonInterested()
    {
        $request = Yii::$app->request;

        $lead = $this->findOrFail($request->post('id'));

        $lead->addLog(
            $request->post('type'),
            $request->post('message'),
            $request->post('notify_at')
        );

        $lead->update(false);

        return Json::encode([
            'success' => true
        ]);
    }

    /**
     * Add 'Ønsker ikke kontakt' log to the lead_log.
     *
     * @return string
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionNotInterested()
    {
        $lead = $this->findOrFail(Yii::$app->request->post('id'));

        $this->authorize('management', $lead);

        /** @var User $user */
        $user = Yii::$app->user->identity;

        $lead->broker_id = null;
        $lead->request_phone_at = null;
        $lead->request_phone_user_id = null;

        $lead->update(false);

        $lead->addLog('1013', $user->getSignature());

        return Json::encode(['success' => true]);
    }

    /**
     * Add 'Ønsker ikke kontakt' log to the lead_log.
     *
     * @return string
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionCommonNotInterested()
    {
        $lead = $this->findOrFail(Yii::$app->request->post('id'));

        /** @var User $user */
        $user = Yii::$app->user->identity;

        $lead->addLog('1013', $user->getSignature());

        return Json::encode(['success' => true]);
    }

    /**
     * Favorite or Unfavorite a lead.
     *
     * @return string
     *
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionFavorite()
    {
        $lead = $this->findOrFail(Yii::$app->request->post('id'));

        if ($lead->isOwner()) {
            $lead->favorite = !$lead->favorite;
            $lead->update(false);
        }

        return Json::encode([
            'success' => true
        ]);
    }

    /**
     * Authorize a given action for the current user.
     *
     * @param $ability
     * @param Forms $lead
     *
     * @return bool
     * @throws HttpException
     */
    protected function authorize($ability, Forms $lead)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if ($user->web_id == $lead->broker_id
            || ($user->web_id == $lead->request_phone_user_id && $lead->request_phone_at >= time())) {
            return true;
        }

        throw new HttpException('Not authorized', 403);
    }

    /**
     * Finds the Forms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Forms the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrFail($id)
    {
        if (($model = Forms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
