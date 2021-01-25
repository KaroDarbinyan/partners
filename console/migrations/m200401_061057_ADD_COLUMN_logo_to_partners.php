<?php

use yii\db\Migration;

/**
 * Class m200401_061057_ADD_COLUMN_logo_to_partners
 */
class m200401_061057_ADD_COLUMN_logo_to_partners extends Migration
{
    private $tableName = "partner";
    private function getColumns(){
        return [
            "logo"=> $this->string(1024),
            "address"=> $this->string(1024),
            "email"=> $this->string(255),
            "telefon"=> $this->string(50),
            "bolignytt"=> $this->string(1024),
            "description"=> $this->text(),
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
