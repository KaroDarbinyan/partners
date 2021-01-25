<?php

use common\models\Forms;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200825_094830_add_pushed_to_webmegler_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'pushed_to_webmegler', $this->boolean()->defaultValue(false));

        Forms::updateAll(
            ['pushed_to_webmegler' => true],
            ['type' => ['book_visning', 'visningliste', 'budvarsel', 'salgsoppgave']]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'pushed_to_webmegler');
    }
}
