<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m200402_170821_add_original_id_column_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%department}}', 'original_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%department}}', 'original_id');
    }
}
