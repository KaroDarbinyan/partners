<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m200406_121142_add_brokers_column_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%department}}', 'brokers', $this->string()->defaultValue('[]'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%department}}', 'brokers');
    }
}
