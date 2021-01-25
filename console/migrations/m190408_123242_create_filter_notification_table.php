<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%filter_notification}}`.
 */
class m190408_123242_create_filter_notification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%filter_notification}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
            'surname'=> $this->string()->notNull(),
            'email'=> $this->string()->notNull(),
            'phone'=> $this->integer()->notNull(),
            'post_number'=> $this->integer()->notNull(),
            'url' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%filter_notification}}');
    }
}
