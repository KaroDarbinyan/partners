<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m191005_115635_add_column_to_user_table extends Migration
{
    private $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['recruitdate']))
            $this->addColumn($this->tableName, 'recruitdate', $this->integer());
        if (!isset($table->columns['dismissaldate']))
            $this->addColumn($this->tableName, 'dismissaldate', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['recruitdate']))
            $this->dropColumn($this->tableName, 'recruitdate');
        if (isset($table->columns['dismissaldate']))
            $this->dropColumn($this->tableName, 'dismissaldate');

        return true;
    }
}
