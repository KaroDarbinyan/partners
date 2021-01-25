<?php

use yii\db\Migration;

/**
 * Class m200502_223431_ADD_LOG_TEST_table
 */
class m200502_223431_ADD_LOG_TEST_table extends Migration
{
    private $tableName = '{{%log_test}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $fields = [
            'id'      => $this->primaryKey(),
            'key'     => $this->integer(15),
            'message' => $this->text(),
        ];

        $this->createTable($this->tableName, $fields, $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

    }
}