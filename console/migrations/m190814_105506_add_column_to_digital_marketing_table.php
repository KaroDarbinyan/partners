<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%digital_marketing}}`.
 */
class m190814_105506_add_column_to_digital_marketing_table extends Migration
{

    private $tableName = '{{%digital_marketing}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['type']))
            $this->addColumn($this->tableName, 'type', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['type']))
            $this->dropColumn($this->tableName, 'type');

        return true;
    }
}
