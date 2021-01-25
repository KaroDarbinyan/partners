<?php

use yii\db\Migration;

/**
 * Class m200416_184501_ADD_COLUMN_bruksenhetsnummer_to_property_details
 */
class m200416_184501_ADD_COLUMN_bruksenhetsnummer_to_property_details extends Migration
{
    private $tableName = "property_details";
    private function getColumns(){
        return [
            "bruksenhetsnummer"=> $this->string(255),
        ];
    }

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
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
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
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }
    }
}

