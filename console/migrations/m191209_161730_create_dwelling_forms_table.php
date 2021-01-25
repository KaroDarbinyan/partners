<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dwelling_forms}}`.
 */
class m191209_161730_create_dwelling_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dwelling_forms}}', [
            'id' => $this->primaryKey(),
            'cost_from' => $this->integer(),
            'cost_to' => $this->integer(),
            'area_from' => $this->integer(),
            'area_to' => $this->integer(),
            'property_type' => $this->string(),
            'region' => $this->string(),
            'rooms' => $this->string(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'subscribe' => $this->boolean()->defaultValue(false),
            'notify_at' => $this->integer()->null(),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dwelling_forms}}');
    }
}
