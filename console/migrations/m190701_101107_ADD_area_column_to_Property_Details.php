<?php

use yii\db\Migration;

/**
 * Class m190701_101107_ADD_area_column_to_Property_Details
 */
class m190701_101107_ADD_area_column_to_Property_Details extends Migration
{
    private $tableName = "property_details";
    private $columnName = "area";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        if(isset($table->columns[$this->columnName])) {
            echo "{$this->tableName}.{$this->columnName} Column already exist \n";
            return;
        }
        $this->addColumn($this->tableName, $this->columnName, $this->string());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        if(!isset($table->columns[$this->columnName])) {
            echo "Column {$this->tableName}.{$this->columnName} dose not exists \n";
            return;
        }
        $this->dropColumn($this->tableName, $this->columnName);
    }


}
