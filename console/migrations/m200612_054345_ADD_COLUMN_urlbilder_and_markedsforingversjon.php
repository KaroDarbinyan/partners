<?php

use yii\db\Migration;

/**
 * Class m200612_054345_ADD_COLUMN_urlbilder_and_markedsforingversjon
 */
class m200612_054345_ADD_COLUMN_urlbilder_and_markedsforingversjon extends Migration
{
    private $tableName = "property_details";
    private function getColumns(){
        return [
            "urlbilder" => $this->string(100),
            "markedsforingversjon" => $this->integer(4),
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
