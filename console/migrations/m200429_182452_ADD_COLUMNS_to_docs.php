<?php

use yii\db\Migration;

/**
 * Class m200429_182452_ADD_COLUMNS_to_docs
 */
class m200429_182452_ADD_COLUMNS_to_docs extends Migration
{
    private $tableName = "docs";
    private function getColumns(){
        return [
            "type_dokumentkategorier" => $this->string(50),
            "typeid" => $this->integer(5),
            "nettpublisert" => $this->boolean(),
            "autoprospekt" => $this->boolean(),
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
