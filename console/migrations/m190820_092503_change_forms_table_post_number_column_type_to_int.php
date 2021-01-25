<?php

use yii\db\Migration;

/**
 * Class m190820_092503_changeformd_table_post_number_calumn_to_int
 */
class m190820_092503_change_forms_table_post_number_column_type_to_int extends Migration
{
    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if ($table && isset($table->columns['post_number']))
        $this->alterColumn($this->tableName, 'post_number', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if ($table && isset($table->columns['post_number']))
            $this->alterColumn($this->tableName, 'post_number', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190820_092503_changeformd_table_post_number_calumn_to_int cannot be reverted.\n";

        return false;
    }
    */
}
