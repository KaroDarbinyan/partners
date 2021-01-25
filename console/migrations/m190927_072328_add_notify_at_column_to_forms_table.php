<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m190927_072328_add_notify_at_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('forms', 'notify_at', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('forms', 'notify_at');
    }
}
