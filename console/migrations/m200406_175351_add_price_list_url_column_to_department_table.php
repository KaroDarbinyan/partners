<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m200406_175351_add_price_list_url_column_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%department}}', 'price_list_url', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%department}}', 'price_list_url');
    }
}
