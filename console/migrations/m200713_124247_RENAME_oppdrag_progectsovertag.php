<?php

use yii\db\Migration;

/**
 * Class m200713_124247_RENAME_oppdrag_progectsovertag
 */
class m200713_124247_RENAME_oppdrag_progectsovertag extends Migration
{

    private $tableName = '{{%property_details}}';
    private $columnName = 'oppdragsnummer_prosjekthovedoppdrag';
    private $columnNewName = 'oppdragsnummer__prosjekthovedoppdrag';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table){
            echo "\ntable Does Not Exists \n";
            return false;
        }
        if (isset($table->columns[$this->columnName])){
            $this->renameColumn($this->tableName, $this->columnName, $this->columnNewName);
        }else{
            echo "\n column not Exists \n";
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table){
            echo "\n table Does Not Exists \n";
            return true;
        }
        if (isset($table->$this->columnNewName)){
            $this->renameColumn($this->tableName, $this->columnNewName, $this->columnName );
        }else{
            echo "\n column not Exists \n";
        }

    }
}
