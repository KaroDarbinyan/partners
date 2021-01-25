<?php

namespace backend\controllers;

use common\models\LeadLog;
use yii\helpers\Json;
use yii\web\Controller;

class LogsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param $id
     *
     * @return string
     */
    public function actionUpdate($id)
    {
        $request = \Yii::$app->request->post('LeadLog');

        $log = LeadLog::findOne($id);

        $log->message = $request['message'];

        if (!empty($request['notify_at'])) {
            $log->notify_at = strtotime($request['notify_at']);
            // $log->inform_in_advance = strtotime("{$request['notify_at']} - {$request['inform_in_advance']}");
        }

        return Json::encode([
            'success' => $log->save(false)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return string
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDestroy($id)
    {
        $log = LeadLog::findOne($id);

        return Json::encode([
            'success' => $log->delete() !== false
        ]);
    }
}
