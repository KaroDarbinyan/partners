<?php

use yii\db\Migration;

/**
 * Class m190510_113322_add_columns_to_forms_table
 */
class m190510_113322_add_columns_to_forms_table extends Migration
{
    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName,true);
        if(!isset($table->columns['send_sms'])) {
            $this->addColumn($this->tableName,'send_sms',$this->boolean()->notNull()->defaultValue(false));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName,true);
        if(!isset($table->columns['send_sms'])) {
            $this->dropColumn($this->tableName,'send_sms');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190510_113322_add_columns_to_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
