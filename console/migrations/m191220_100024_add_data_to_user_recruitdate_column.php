<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m191220_100024_add_data_to_user_recruitdate_column
 */
class m191220_100024_add_data_to_user_recruitdate_column extends Migration
{

    private $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($table = $this->db->getTableSchema($this->tableName, true)) {
            if (isset($table->columns['recruitdate'])) {
                User::updateAll(['recruitdate' => strtotime("01 Jan 2015 00:00:00 +0400")]);
            } else {
                echo "Table {$this->tableName}.recruitdate column dose not exist \n";
                return;
            }
        } else {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191220_100024_add_data_to_user_recruitdate_column reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_100024_add_data_to_user_recruitdate_column cannot be reverted.\n";

        return false;
    }
    */
}
