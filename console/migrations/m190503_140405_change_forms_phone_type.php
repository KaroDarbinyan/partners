<?php

use yii\db\Migration;

/**
 * Class m190503_140405_change_forms_phone_type
 */
class m190503_140405_change_forms_phone_type extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('forms',  'phone', $this->string());
        $this->alterColumn('filter_notification',  'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema('forms', true) !== null) {
            $this->alterColumn('forms', 'phone', $this->integer());
        }
        if ($this->db->getTableSchema('filter_notification', true) !== null) {
            $this->alterColumn('filter_notification', 'phone', $this->integer());
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190503_140405_change_forms_phone_type cannot be reverted.\n";

        return false;
    }
    */
}
