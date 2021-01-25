<?php

use yii\db\Migration;

/**
 * Class m190430_091421_add_columns_to_user_table
 */
class m190430_091421_add_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'inaktiv_status', $this->integer()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $this->dropColumn('{{%user}}', 'inaktiv_status');
        $this->execute("SET foreign_key_checks = 1;");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190430_091421_add_columns_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
