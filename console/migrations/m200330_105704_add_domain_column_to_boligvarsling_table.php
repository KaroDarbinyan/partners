<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%boligvarsling}}`.
 */
class m200330_105704_add_domain_column_to_boligvarsling_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%boligvarsling}}', 'domain', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%boligvarsling}}', 'domain');
    }
}
