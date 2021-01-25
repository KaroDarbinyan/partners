<?php

use yii\db\Migration;

/**
 * Class m190808_132420_RENAME_COLUMN_user_deprtment_id_to_department_id
 */
class m190808_132420_RENAME_COLUMN_user_deprtment_id_to_department_id extends Migration
{

    private $tableName = '{{%user}}';
    private $columnName = 'deprtment_id';

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
            $this->renameColumn($this->tableName, $this->columnName, 'department_id');
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
        if (isset($table->columns['department_id'])){
            $this->renameColumn($this->tableName, 'department_id', $this->columnName );
        }else{
            echo "\n column not Exists \n";
        }

    }
}
