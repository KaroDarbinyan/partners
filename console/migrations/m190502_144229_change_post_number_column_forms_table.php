<?php

use yii\db\Migration;

/**
 * Class m190502_144229_change_post_number_column_forms_table
 */
class m190502_144229_change_post_number_column_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('forms', 'post_number', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('forms', 'post_number', $this->integer()->defaultValue(null));

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190502_144229_change_post_number_column_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
