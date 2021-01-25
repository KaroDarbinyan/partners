<?php

use yii\db\Migration;

/**
 * Class m190819_133947_ADD_COLUMN_markedsforingsdato_to_property_details
 */
class m190819_133947_ADD_COLUMN_markedsforingsdato_to_property_details extends Migration
{

    private $tableName = '{{%property_details}}';
    private $columnName = '{{%markedsforingsdato}}';

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
        if (!isset($table->columns[$this->columnName])){
            $this->addColumn($this->tableName, $this->columnName, $this->integer(11));
        }else{
            echo "\n column already Exists \n";
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
        if (!isset($table->columns[$this->columnName])){
            $this->dropColumn($this->tableName, $this->columnName);
        }else{
            echo "\n column already Exists \n";
        }

    }
}
