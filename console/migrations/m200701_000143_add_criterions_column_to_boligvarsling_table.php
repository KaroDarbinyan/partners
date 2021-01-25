<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%boligvarsling}}`.
 */
class m200701_000143_add_criterions_column_to_boligvarsling_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%boligvarsling}}', 'criterions', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%boligvarsling}}', 'criterions');
    }
}
