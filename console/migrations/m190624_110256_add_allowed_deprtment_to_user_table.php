<?php

use yii\db\Migration;

/**
 * Class m190624_110256_add_allowed_deprtment_to_user_table
 */
class m190624_110256_add_allowed_deprtment_to_user_table extends Migration
{
    private $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!isset($table->columns['allowed_deprtment']))
            $this->addColumn($this->tableName, 'allowed_deprtment', $this->integer(11)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table->columns['allowed_deprtment']))
            $this->dropColumn($this->tableName, 'allowed_deprtment');
        echo "m190624_110256_add_allowed_deprtment_to_user_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190624_110256_add_allowed_deprtment_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
