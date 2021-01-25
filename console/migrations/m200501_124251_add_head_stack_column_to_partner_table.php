<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%partner}}`.
 */
class m200501_124251_add_head_stack_column_to_partner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%partner}}', 'head_stack', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%partner}}', 'head_stack');
    }
}
