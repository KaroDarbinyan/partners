<?php

use yii\db\Migration;

/**
 * Class m200513_043907_CREATE_TABLE_process
 */
class m200513_043907_CREATE_TABLE_process extends Migration
{
    private $tableName = '{{%process}}';

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
            'id'           => $this->primaryKey(),
            'pid'          => $this->integer(10),
            'db_id'        => $this->integer(4),
            'createdate'    => $this->integer(11),
            'requestdate'  => $this->integer(11),
            'type'         => $this->string(10),
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