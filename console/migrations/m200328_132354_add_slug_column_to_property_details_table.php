<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property_details}}`.
 */
class m200328_132354_add_slug_column_to_property_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%property_details}}', 'slug', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%property_details}}', 'slug');
    }
}
