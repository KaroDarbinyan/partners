<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%all_post_number}}`.
 */
class m191111_125544_add_neighbourhood_column_to_all_post_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('all_post_number', 'neighbourhood', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('all_post_number', 'neighbourhood');
    }
}
