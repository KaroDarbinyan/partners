<?php

use yii\db\Migration;

/**
 * Class m190625_125825_add_allowed_deprtment_title_to_user_table
 */
class m190625_125825_add_allowed_deprtment_title_to_user_table extends Migration
{
    private $tableName = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!isset($table->columns['allowed_deprtment_title']))
            $this->addColumn($this->tableName, 'allowed_deprtment_title', $this->text()->notNull()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table->columns['allowed_deprtment_title']))
            $this->dropColumn($this->tableName, 'allowed_deprtment_title');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190625_125825_add_allowed_deprtment_title_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
