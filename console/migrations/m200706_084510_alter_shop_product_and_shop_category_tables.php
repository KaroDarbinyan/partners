<?php

use yii\db\Migration;

/**
 * Class m200706_084510_alter_shop_product_and_shop_category_tables
 */
class m200706_084510_alter_shop_product_and_shop_category_tables extends Migration
{
    private $tables = ["shop_product", "shop_category"];

    private $column = "slug";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->tables as $item) {
            $table = $this->db->getTableSchema($item, true);
            if (!$table) {
                echo "Table {$item} dose not exist \n";
                return;
            }
            if (isset($table->columns[$this->column]))
                $this->dropColumn($item, $this->column);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->tables as $item) {
            $table = $this->db->getTableSchema($item, true);
            if (!$table) {
                echo "Table {$item} dose not exist \n";
                return;
            }
            if (!isset($table->columns[$this->column]))
                $this->addColumn($item, $this->column, $this->string());
        }
    }
}