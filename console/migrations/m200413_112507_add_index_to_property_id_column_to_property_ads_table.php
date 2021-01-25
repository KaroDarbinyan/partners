<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property_ads}}`.
 */
class m200413_112507_add_index_to_property_id_column_to_property_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('property_id', '{{%property_ads}}', 'property_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('property_id', '{{%property_ads}}');
    }
}
