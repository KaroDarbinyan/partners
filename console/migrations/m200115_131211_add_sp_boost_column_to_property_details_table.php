<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property_details}}`.
 */
class m200115_131211_add_sp_boost_column_to_property_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%property_details}}', 'sp_boost', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%property_details}}', 'sp_boost');
    }
}
