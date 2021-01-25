<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%lead_log}}`.
 */
class m190920_073409_add_notify_columns_to_lead_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lead_log', 'notify_at', $this->integer()->null());
        $this->addColumn('lead_log', 'inform_in_advance', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lead_log', 'notify_at');
        $this->dropColumn('lead_log', 'inform_in_advance');
    }
}
