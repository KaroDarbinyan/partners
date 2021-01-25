<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sp_boost}}`.
 */
class m200428_135001_create_sp_boost_table extends Migration
{

    private $tableName = "{{%sp_boost}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->batchInsert($this->tableName, ["name"], [
            ['Medium'], ['Deluxe'], ['Extra annonsering']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}
