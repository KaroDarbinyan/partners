<?php

use yii\db\Migration;

/**
 * Class m190821_204416_CHANGE_VISITS_date_formats_to_seconds
 */
class m190821_204416_CHANGE_VISITS_date_formats_to_seconds extends Migration
{
    private $tableName = "property_visits";
    private $columns = ["fra","til"];
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
        foreach ($this->columns as $column) {
            if(!isset($table->columns[$column])) {
                echo "{$this->tableName}.{$column} column is missing \n";
                continue;
            }
            $this->alterColumn($this->tableName, $column, $this->integer(11)->null());

        }
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
        foreach ($this->columns as $column) {
            if(!isset($table->columns[$column])) {
                echo "{$this->tableName}.{$column} column is missing \n";
                continue;
            }
            $this->alterColumn($this->tableName, $column, $this->timestamp());

        }
    }


}
