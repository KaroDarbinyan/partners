<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%all_post_number}}`.
 */
class m191205_124118_add_column_to_all_post_number_table extends Migration
{

    private $tableName = '{{%all_post_number}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['area1']))
            $this->addColumn($this->tableName, 'area1', $this->string());
        if (!isset($table->columns['area2']))
            $this->addColumn($this->tableName, 'area2', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['area1']))
            $this->dropColumn($this->tableName, 'area1');
        if (isset($table->columns['area2']))
            $this->dropColumn($this->tableName, 'area2');

        return true;
    }
}
