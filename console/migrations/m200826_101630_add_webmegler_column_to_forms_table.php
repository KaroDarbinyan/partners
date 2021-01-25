<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200826_101630_add_webmegler_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'push_attempts', $this->integer()->unsigned()->defaultValue(0));
        $this->addColumn('{{%forms}}', 'push_error', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'push_attempts');
        $this->dropColumn('{{%forms}}', 'push_error');
    }
}
