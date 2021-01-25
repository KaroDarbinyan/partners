<?php

use yii\db\Migration;

/**
 * Class m200612_050159_CREATE_kriteries
 */
class m200612_050159_CREATE_kriteries extends Migration
{
    private $tableName = '{{%criterias}}';

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
            'id'              => $this->primaryKey(),
            'property_web_id' => $this->integer(10),
            'id_typer'        => $this->integer(5),
            'navn'            => $this->string(255),
            'iadnavn'         => $this->string(255),
            'db_id'           => $this->integer(4),
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
