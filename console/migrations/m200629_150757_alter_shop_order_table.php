<?php

use common\models\ShopOrder;
use yii\db\Migration;

/**
 * Class m200629_150757_alter_shop_order_table
 */
class m200629_150757_alter_shop_order_table extends Migration
{
    private $tableName = "shop_order";

    private function removeColumns()
    {
        return [
            "index" => $this->string(),
            "product_id" => $this->integer(),
            "product_count" => $this->integer(),
            "sum" => $this->integer(),
        ];
    }

    private function getColumns()
    {
        return [
            "products" => $this->text(),
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

        ShopOrder::deleteAll();
        foreach ($this->getColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
        }

        foreach (array_keys($this->removeColumns()) as $column) {
            if (isset($table->columns[$column])) {
                $this->dropColumn($this->tableName, $column);
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
        foreach ($this->getColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }

        foreach ($this->removeColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
        }

    }
}
