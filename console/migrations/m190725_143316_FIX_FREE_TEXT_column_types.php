<?php

use yii\db\Migration;

/**
 * Class m190725_143316_FIX_FREE_TEXT_column_types
 */
class m190725_143316_FIX_FREE_TEXT_column_types extends Migration
{
    private $tableName = "{{%free_text}}";
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
        $columns = [
            ['nr', $this->integer(3)],
            ['visinettportaler', $this->integer(2)],
            ['compositeTextId', $this->integer(11)],
            ['gruppenavn', $this->char(50)],
            ['overskrift', $this->char(255)],
            ['tekst'],
            ['htmltekst', 'LONGTEXT'],
        ];
        foreach ($columns as $column) {
            if(!isset($table->columns[$column[0]])) {
                echo "{$this->tableName}.{$column[0]} column is missing \n";
                continue;
            }
            if (count($column) == 2){
                $this->alterColumn($this->tableName, $column[0], $column[1]);
            }else{
                $this->dropColumn($this->tableName, $column[0]);
            }
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
