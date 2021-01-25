<?php

use yii\db\Migration;

/**
 * Class m200331_102339_ADD_CILOMN_wapi_id_to_partners
 */
class m200331_102339_ADD_CILOMN_wapi_id_to_partners extends Migration
{
    private $tableName = "partner";
    private function getColumns(){
        return [
            "wapi_id"=> $this->integer(4)->defaultValue(233),
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

        $this->execute("UPDATE {$this->tableName} SET wapi_id = 343 WHERE id = 1;");
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
