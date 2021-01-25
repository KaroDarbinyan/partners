<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%forms}}`.
 */
class m191209_193700_drop_unused_columns_from_forms_table extends Migration
{
    private $tableName = "forms";
    private function getColumns(){
        return [
            'property_type'=>$this->string()->null(),
            'price_range'=>$this->string()->null(),
            'area_range'=>$this->string()->null(),
            'notify_at'=>$this->integer()->null(),
            'cost_from'=>$this->integer()->null(),
            'cost_to'=>$this->integer()->null(),
            'area_from'=>$this->integer()->null(),
            'area_to'=>$this->integer()->null(),
            'region'=>$this->string()->null(),
            'rooms'=>$this->string()->null(),
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
                $this->addColumn($this->tableName, $name, $type);

            }
        }
    }
}
