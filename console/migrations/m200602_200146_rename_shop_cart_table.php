<?php

use yii\db\Migration;

/**
 * Class m200602_200146_rename_shop_cart_table
 */
class m200602_200146_rename_shop_cart_table extends Migration
{

    private $dropTableName = "{{%shop_cart}}";
    private $newTableName = "{{%shop_basket}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->dropTableName, true) !== null) {
            $this->dropTable($this->dropTableName);
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->newTableName, true) !== null) {
            $this->dropTable($this->newTableName);
        }


        $this->createTable($this->newTableName, [
            "id" => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->dropTableName, true) !== null) {
            $this->dropTable($this->dropTableName);
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->newTableName, true) !== null) {
            $this->dropTable($this->newTableName);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200602_200146_rename_shop_cart_table cannot be reverted.\n";

        return false;
    }
    */
}
