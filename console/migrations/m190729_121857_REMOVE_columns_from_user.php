<?php

use yii\db\Migration;

/**
 * Class m190729_121857_REMOVE_columns_from_user
 */
class m190729_121857_REMOVE_columns_from_user extends Migration
{
    private $tableName = "{{%user}}";
    private function getColumns(){
        return [
            'stilling',
            'urlhtmlpresentasjon_ansatt',
            'bilder',
            'properties',
            'telefon',
            'telefax',
        ];
    }

    private function getSpecialColumns(){
        return [
            'status'=>$this->smallInteger()->notNull()->defaultValue(10),
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

        foreach ($this->getSpecialColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->alterColumn($this->tableName,$name, $type);
            }else{
                $this->addColumn($this->tableName,$name, $type);
            }
            echo "\n {$name} fixed \n";
        }

        foreach ($this->getColumns() as $i => $name) {

            if(!isset($table->columns[$name])) {
                continue;
            }
            $this->dropColumn($this->tableName, $name);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo 'this migration reverted partial';
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
            $this->addColumn($this->tableName, $name, 'LONGTEXT');
        }
    }

}
