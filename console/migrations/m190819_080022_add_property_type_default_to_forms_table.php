<?php

use yii\db\Migration;

/**
 * Class m190819_080022_add_property_type_default_to_forms_table
 */
class m190819_080022_add_property_type_default_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('forms', 'property_type', $this->string()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190819_080022_add_property_type_default_to_forms_table cannot be reverted.\n";

        $this->alterColumn('forms', 'property_type', $this->string()->notNull());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190819_080022_add_property_type_default_to_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
