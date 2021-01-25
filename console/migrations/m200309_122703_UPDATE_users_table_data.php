<?php

use yii\db\Migration;

/**
 * Class m200309_122703_UPDATE_users_table_data
 */
class m200309_122703_UPDATE_users_table_data extends Migration
{
    private $tableName = 'user';

    /**
     * {@inheritdoc}
     * @throws \Matrix\Exception
     * @throws \yii\base\Exception
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }

        $this->execute(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "sqls" . DIRECTORY_SEPARATOR . "schala_prod_user03.09.2020.sql"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_122703_UPDATE_users_table_data cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200221_091513_IMPORT_users_to_databases cannot be reverted.\n";

        return false;
    }
    */
}
