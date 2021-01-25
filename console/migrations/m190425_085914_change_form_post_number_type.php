<?php

use yii\db\Migration;

/**
 * Class m190425_085914_change_form_post_number_type
 */
class m190425_085914_change_form_post_number_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('forms',  'post_number', $this->string());
        $this->alterColumn('filter_notification',  'post_number', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema('forms', true) !== null) {
            $this->alterColumn('forms', 'post_number', $this->integer());
        }
        if ($this->db->getTableSchema('filter_notification', true) !== null) {
            $this->alterColumn('filter_notification', 'post_number', $this->integer());
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190425_085914_change_form_post_number_type cannot be reverted.\n";

        return false;
    }
    */
}
