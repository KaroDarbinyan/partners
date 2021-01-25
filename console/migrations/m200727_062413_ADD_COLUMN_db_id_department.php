<?php

use yii\db\Migration;

/**
 * Class m200727_062413_ADD_COLUMN_db_id_department
 */
class m200727_062413_ADD_COLUMN_db_id_department extends Migration
{
    private $tableName = "department";

    private function getColumns(){
        return [
            "databasenummer" => $this->integer(4),
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

        $this->execute("
          UPDATE {$this->tableName}
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
