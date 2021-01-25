<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m191125_161053_add_request_phone_columns_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('forms', 'request_phone_user_id', $this->integer()->null());
        $this->addColumn('forms', 'request_phone_at', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('forms', 'request_phone_user_id');
        $this->dropColumn('forms', 'request_phone_at');
    }
}
