<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200410_140538_add_partner_id_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'partner_id', $this->integer()->null());
        $this->createIndex('forms_partner_id', '{{%forms}}', 'partner_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('forms_partner_id', '{{%forms}}');
        $this->dropColumn('{{%forms}}', 'partner_id');
    }
}
