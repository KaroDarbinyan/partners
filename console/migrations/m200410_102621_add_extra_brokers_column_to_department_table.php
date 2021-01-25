<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m200410_102621_add_extra_brokers_column_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%department}}', 'extra_brokers', $this->string()->defaultValue('[]'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%department}}', 'extra_brokers');
    }
}
