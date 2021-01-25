<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%log_lead}}`.
 */
class m191022_101829_add_user_id_column_to_log_lead_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lead_log', 'user_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lead_log', 'user_id');
    }
}
