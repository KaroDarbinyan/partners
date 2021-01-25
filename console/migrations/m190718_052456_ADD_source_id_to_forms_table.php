<?php

use yii\db\Migration;

/**
 * Class m190718_052456_ADD_source_id_to_forms_table
 */
class m190718_052456_ADD_source_id_to_forms_table extends Migration
{
    private $tableName = "forms";
    private $file = "webmegler-data/bydel-oslo.csv";

    private function getColumns(){
        return ["source_id"=>$this->integer(11), "source"=>$this->string(1024)];
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
                echo "Column {$this->tableName}.{$name} already exists \n";
                continue;
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
            if(!isset($table->columns[$name])) {
                echo "Column {$this->tableName}.{$name} dose not exists \n";
                continue;
            }
            $this->dropColumn($this->tableName, $name);
        }
    }

}
