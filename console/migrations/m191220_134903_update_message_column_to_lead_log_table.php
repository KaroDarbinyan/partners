<?php

use yii\db\Migration;

/**
 * Class m191220_134903_update_message_column_to_lead_log_table
 */
class m191220_134903_update_message_column_to_lead_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('lead_log', 'message', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('lead_log', 'message', $this->string()->notNull());
    }
}
