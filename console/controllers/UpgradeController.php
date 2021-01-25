<?php

namespace console\controllers;

use common\models\Client;
use common\models\LeadLog;
use console\models\Forms;
use yii\console\Controller;

class UpgradeController extends Controller
{
    public function actionFormStatusTextToId()
    {
        $translationsFile = \Yii::getAlias('@common') . '/messages/nb/lead_log.php';

        if (file_exists($translationsFile)) {
            $translations = include_once $translationsFile;

            foreach ($translations as $key => $translation) {
                Forms::updateAll(['status' => $key], ['status' => $translation]);
                Forms::updateAll(['handle_type' => $key], ['handle_type' => $translation]);
                LeadLog::updateAll(['type' => $key], ['type' => $translation]);
                Client::updateAll(['status' => $key], ['status' => $translation]);
            }
        }
    }
}
