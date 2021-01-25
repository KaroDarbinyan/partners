<?php

use common\models\Client;
use common\models\Forms;
use common\models\LeadLog;
use yii\db\Migration;

/**
 * Class m200211_085421_update_lead_log_and_client_table
 */
class m200211_085421_update_lead_log_and_client_table extends Migration
{
    public $translations = [];

    public function __construct($config = [])
    {
        $translationsFile = Yii::getAlias('@common') . '/messages/nb/lead_log.php';

        if (file_exists($translationsFile)) {
            $this->translations = include_once $translationsFile;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->translations as $key => $translation) {
            Forms::updateAll(['status' => $key], ['status' => $translation]);
            Forms::updateAll(['handle_type' => $key], ['handle_type' => $translation]);
            LeadLog::updateAll(['type' => $key], ['type' => $translation]);
            Client::updateAll(['status' => $key], ['status' => $translation]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->translations as $key => $translation) {
            Forms::updateAll(['status' => $translation], ['status' => (string)$key]);
            Forms::updateAll(['handle_type' => $translation], ['handle_type' => (string)$key]);
            LeadLog::updateAll(['type' => $translation], ['type' => (string)$key]);
            Client::updateAll(['status' => $translation], ['status' => (string)$key]);
        }
    }
}
