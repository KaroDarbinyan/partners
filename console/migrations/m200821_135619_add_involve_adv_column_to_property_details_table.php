<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property_details}}`.
 */
class m200821_135619_add_involve_adv_column_to_property_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%property_details}}', 'involve_adv', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%property_details}}', 'involve_adv');
    }
}
