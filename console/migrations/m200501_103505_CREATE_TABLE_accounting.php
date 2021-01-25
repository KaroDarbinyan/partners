<?php

use yii\db\Migration;

/**
 * Class m200501_103505_CREATE_TABLE_accounting
 */
class m200501_103505_CREATE_TABLE_accounting extends Migration
{
    private $tableName = '{{%accounting}}';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
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
            'id_firma'      => $this->integer(10),
            'firma'         => $this->string(255),
            'bilagsnummer'  => $this->integer(7),
            'bilagsdato'    => $this->integer(11),
            'endretdato'    => $this->integer(11),
            'linjenummer'   => $this->integer(10),
            'id_avdelinger' => $this->integer(10),
            'avdeling'      => $this->string(255),
            'id_ansatte'    => $this->integer(10),
            'ansatt'        => $this->string(255),
            'oppdragsnummer'=> $this->integer(10),
            'adresse'       => $this->string(255),
            'konto'         => $this->integer(10),
            'kontonavn'     => $this->string(255),
            'kommentar'     => $this->text(),
            'belop'         => $this->string(255)
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
