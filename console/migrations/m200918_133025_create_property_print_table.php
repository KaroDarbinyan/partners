<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_print}}`.
 */
class m200918_133025_create_property_print_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_print}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->unsigned(),
            'comment' => $this->text()->null(),
            'fb_ab_at' => $this->dateTime()->null(),
            'fb_video_at' => $this->dateTime()->null(),
            'fb_video_url' => $this->string()->null(),
            'delta_at' => $this->dateTime()->null(),
            'instagram_at' => $this->dateTime()->null(),
            'sold_at' => $this->dateTime()->null()
        ]);

        $this->createIndex('print_property_id', '{{%property_print}}', ['property_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('print_property_id', '{{%property_print}}');
        $this->dropTable('{{%property_print}}');
    }
}
