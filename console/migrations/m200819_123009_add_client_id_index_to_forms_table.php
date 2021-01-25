<?php

use yii\db\Migration;

/**
 * Class m200819_123009_add_client_id_index_to_forms_table
 */
class m200819_123009_add_client_id_index_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('forms_client_id', '{{%forms}}', ['client_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('forms_client_id', '{{%forms}}');
    }
}
