<?php

use yii\db\Migration;

/**
 * Class m200410_180739_ADD_COLUMN_partner_id_to_forms
 */
class m200410_180739_ADD_COLUMN_partner_id_to_forms extends Migration
{
    private $tableName = "forms";
    private function getColumns(){
        return [
            "partner_id"=> $this->integer(11),
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
        $dep = \common\models\Department::tableName();
        $this->execute("
            UPDATE {$this->tableName} 
            LEFT JOIN {$dep} ON {$this->tableName}.department_id = {$dep}.web_id 
            SET {$this->tableName}.partner_id = {$dep}.partner_id
        ");
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

