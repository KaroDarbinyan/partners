<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m191023_102343_add_additional_columns_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('forms', 'cost_from', $this->integer()->null());
        $this->addColumn('forms', 'cost_to', $this->integer()->null());
        $this->addColumn('forms', 'area_from', $this->integer()->null());
        $this->addColumn('forms', 'area_to', $this->integer()->null());
        $this->addColumn('forms', 'region', $this->string()->null());
        $this->addColumn('forms', 'rooms', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('forms', 'cost_from');
        $this->dropColumn('forms', 'cost_to');
        $this->dropColumn('forms', 'area_from');
        $this->dropColumn('forms', 'area_to');
        $this->dropColumn('forms', 'region');
        $this->dropColumn('forms', 'rooms');
    }
}
