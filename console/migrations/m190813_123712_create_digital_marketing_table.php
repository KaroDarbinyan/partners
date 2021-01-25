<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%digital_marketing}}`.
 */
class m190813_123712_create_digital_marketing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%digital_marketing}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(),
            'start' => $this->bigInteger(),
            'stop' => $this->bigInteger(),
            'campaign_name' => $this->string(),
            'source_object_id' => $this->integer(),
            'live' => $this->boolean(),
            'completed' => $this->boolean(),
            'creative_a_stats' => $this->string(),
            'creative_b_stats' => $this->string(),
            'stats' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%digital_marketing}}');
    }
}
