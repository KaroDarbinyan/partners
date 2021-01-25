<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200804_111158_add_boligvarsling_id_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'boligvarsling_id', $this->integer()->unsigned()->null());
        $this->createIndex('forms_boligvarsling_id', '{{%forms}}', ['boligvarsling_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('forms_boligvarsling_id', '{{%forms}}');
        $this->dropColumn('{{%forms}}', 'boligvarsling_id');
    }
}
