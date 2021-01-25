<?php

use yii\db\Migration;

/**
 * Class m200623_221700_add_column_sum_to_shop_order_table
 */
class m200623_221700_add_column_sum_to_shop_order_table extends Migration
{
    private $tableName = "shop_order";

    private function getColumns()
    {
        return [
            "sum" => $this->string(),
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
        foreach ($this->getColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
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
        foreach ($this->getColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }

    }
}
