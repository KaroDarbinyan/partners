<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m191211_080613_add_favorite_columns_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'favorite', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'favorite');
    }
}
