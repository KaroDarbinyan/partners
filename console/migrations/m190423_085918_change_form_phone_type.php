<?php

use yii\db\Migration;

/**
 * Class m190423_085918_change_form_phone_type
 */
class m190423_085918_change_form_phone_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('forms', true) !== null) {
            $this->alterColumn('forms', 'phone', $this->string());
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema('forms', true) !== null) {
            $this->alterColumn('forms', 'phone', $this->integer());
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190423_085918_change_form_phone_type cannot be reverted.\n";

        return false;
    }
    */
}
