<?php

use yii\db\Migration;

/**
 * Class m190410_100031_change_columns_to_form_table
 */
class m190410_100031_change_columns_to_form_table extends Migration
{

    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $this->createTable( $this->tableName, [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string(),
            'post_number' => $this->integer()->notNull(),
            'phone' => $this->integer()->notNull(),
            'email' => $this->string(),
            'message' => $this->text(),
            'subscribe_email' => $this->boolean()->notNull()->defaultValue(false),
            'advice_to_email' => $this->boolean()->notNull()->defaultValue(false),
            'contact_me' => $this->boolean()->notNull()->defaultValue(false),
            'type'=> $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],$tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190410_100031_change_columns_to_form_table cannot be reverted.\n";

        return false;
    }
    */
}
