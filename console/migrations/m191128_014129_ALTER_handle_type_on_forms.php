<?php

use yii\db\Migration;

/**
 * Class m191128_014129_ALTER_handle_type_on_forms
 */
class m191128_014129_ALTER_handle_type_on_forms extends Migration
{
    private $tableName = "forms";
    private $sTableName = "client";

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $name = 'handle_type';
        $type = $this->char(32)->null();
        if(isset($table->columns[$name])) {
            $this->alterColumn($this->tableName, $name, $type);
        }
        $name = 'status';
        if(isset($table->columns[$name])) {
            $this->alterColumn($this->tableName, $name, $type);
        }

        $table = $this->db->getTableSchema($this->sTableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $name = 'status';
        if(isset($table->columns[$name])) {
            $this->alterColumn($this->tableName, $name, $type);
        }

    }

    public function down()
    {
        echo "m191128_014129_ALTER_handle_type_on_forms Revert changes may be ignored \n";
    }

}
