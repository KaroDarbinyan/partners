<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m191004_105210_add_part_of_city_column_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('department', 'part_of_city', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('department', 'part_of_city');
    }
}
