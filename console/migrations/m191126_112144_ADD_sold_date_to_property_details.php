<?php

use yii\db\Migration;

/**
 * Class m191126_112144_ADD_sold_date_to_property_details
 */
class m191126_112144_ADD_sold_date_to_property_details extends Migration
{
    private $tableName = "property_details";
    private function getColumns(){
        return [
            "sold_date"=> $this->integer(11),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
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
