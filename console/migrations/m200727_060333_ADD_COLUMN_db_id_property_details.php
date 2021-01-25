<?php

use yii\db\Migration;

/**
 * Class m200727_060333_ADD_COLUMN_db_id_property_details
 */
class m200727_060333_ADD_COLUMN_db_id_property_details extends Migration
{
    private $tableName = "property_details";
    private $tables = "property_details";
    private function getColumns(){
        return [
            "databasenummer" => $this->integer(4),
            "web_id" => $this->integer(11),
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

        $this->execute("UPDATE {$this->tableName} SET web_id = id");
        $this->execute("
          UPDATE {$this->tableName} 
          left join department on {$this->tableName}.avdeling_id = department.web_id
          left join partner on department.partner_id = partner.id 
          
          SET databasenummer = partner.wapi_id
          where partner.id IS NOT NULL
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
