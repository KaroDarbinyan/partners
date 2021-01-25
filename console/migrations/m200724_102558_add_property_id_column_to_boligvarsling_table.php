<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%boligvarsling}}`.
 */
class m200724_102558_add_property_id_column_to_boligvarsling_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%boligvarsling}}', 'property_id', $this->integer()->null());
        $this->createIndex('boligvarsling_property_id', '{{%boligvarsling}}', 'property_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('boligvarsling_property_id', '{{%boligvarsling}}');
        $this->dropColumn('{{%boligvarsling}}', 'property_id');
    }
}
