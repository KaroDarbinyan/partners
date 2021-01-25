<?php

use console\components\MultyConnection;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m200319_094051_add_bolignytt_column_to_department_table extends Migration
{

    private $tableName = '{{%department}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if(!$tableSchema){
            echo 'table not exist';return;// table not exist
        }
        if (!isset($tableSchema->columns["bolignytt"])) $this->addColumn($this->tableName, "bolignytt", $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if(!$tableSchema){
            echo 'table not exist';return;// table not exist
        }
        if (isset($tableSchema->columns["bolignytt"])) $this->dropColumn($this->tableName, "bolignytt");

    }
}
