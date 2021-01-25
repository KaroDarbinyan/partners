<?php

use common\models\News;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news}}`.
 */
class m200411_101315_add_user_role_column_to_news_table extends Migration
{

    private $tableName = '{{%news}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if (!isset($tableSchema->columns["user_role"])) $this->addColumn($this->tableName, "user_role", $this->string());

        News::updateAll(["user_role" => "partner-director-broker"]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if (isset($tableSchema->columns["user_role"])) $this->dropColumn($this->tableName, "user_role");

    }
}
