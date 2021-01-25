<?php

use yii\db\Migration;

/**
 * Class m190808_103605_ADD_COLUMN_department_id__to_forms
 */
class m190808_103605_ADD_COLUMN_department_id__to_forms extends Migration
{

    private $tableName = '{{%forms}}';
    private $columnName = '{{%department_id}}';

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
