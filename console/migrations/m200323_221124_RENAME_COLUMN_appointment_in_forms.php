<?php

use yii\db\Migration;

/**
 * Class m200323_221124_RENAME_COLUMN_appointment_in_forms
 */
class m200323_221124_RENAME_COLUMN_appointment_in_forms extends Migration
{
    private $tableName = "forms";

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $name = 'appointment';
        if(isset($table->columns[$name])) {
            $this->renameColumn($this->tableName, $name,'book_visning');
        }

    }

    public function down()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $name = 'book_visning';
        if(isset($table->columns[$name])) {
            $this->renameColumn($this->tableName, $name,'appointment');
        }
    }

}