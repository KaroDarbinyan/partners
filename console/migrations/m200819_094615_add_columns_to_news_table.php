<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news}}`.
 */
class m200819_094615_add_columns_to_news_table extends Migration
{
    private $tableName = '{{%news}}';
    private $columnName = 'viewings';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns[$this->columnName]))
            $this->addColumn($this->tableName, $this->columnName, $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns[$this->columnName]))
            $this->dropColumn($this->tableName, $this->columnName);

        return true;
    }
}
