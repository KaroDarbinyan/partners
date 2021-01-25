<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property_details}}`.
 */
class m190910_114853_add_adv_columns_to_property_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('property_details', 'adv_in_fb', $this->boolean()->null()->defaultValue(0));
        $this->addColumn('property_details', 'adv_in_insta', $this->boolean()->null()->defaultValue(0));
        $this->addColumn('property_details', 'adv_in_video', $this->boolean()->null()->defaultValue(0));
        $this->addColumn('property_details', 'adv_in_solgt', $this->boolean()->null()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('property_details', 'adv_in_fb');
        $this->dropColumn('property_details', 'adv_in_insta');
        $this->dropColumn('property_details', 'adv_in_video');
        $this->dropColumn('property_details', 'adv_in_solgt');
    }
}
