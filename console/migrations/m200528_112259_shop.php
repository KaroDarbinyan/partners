<?php

use yii\db\Migration;

/**
 * Class m200528_112259_shop
 */
class m200528_112259_shop extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->removeTables();

        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        foreach ($this->getTables() as $table => $columns) {
            $this->createTable($table, $columns, $tableOptions);
            echo "table {$table} created";
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->removeTables();
    }


    private function removeTables()
    {
        foreach (array_keys($this->getTables()) as $table) {
            if ($this->db->getTableSchema($table, true) !== null) {
                $this->dropTable($table);
                echo "table {$table} deleted";
            }
        }
    }


    private function getTables()
    {
        return [
            "shop_category" => [
                "id" => $this->primaryKey(),
                'name' => $this->string(),
                'slug' => $this->string(),
                'description' => $this->text(),
                'active' => $this->boolean()->defaultValue(true),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            "shop_product" => [
                "id" => $this->primaryKey(),
                'category_id' => $this->integer(),
                'name' => $this->string(),
                'description' => $this->text(),
                'slug' => $this->string(),
                'price' => $this->double(),
                'active' => $this->boolean()->defaultValue(true),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            "shop_order" => [
                "id" => $this->primaryKey(),
                'user_id' => $this->integer(),
                'status' => $this->string(),
                'date' => $this->string(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            "shop_cart" => [
                "id" => $this->primaryKey(),
                'user_id' => $this->integer(),
                'product_id' => $this->integer(),
                'date' => $this->string(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            "shop_image" => [
                "id" => $this->primaryKey(),
                'product_id' => $this->integer(),
                'category_id' => $this->integer(),
                'name' => $this->string(),
                'main' => $this->boolean(),
            ]
        ];
    }

}
