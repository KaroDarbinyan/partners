<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_nabolagsprofil}}`.
 */
class m190906_081037_create_property_nabolagsprofil_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_nabolagsprofil}}', [
            'id' => $this->primaryKey(),
            'percent_text_data' => $this->text(),
            'property_web_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%property_nabolagsprofil}}');
    }
}
