<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m200128_123914_add_columns_access_token_and_expire_at_to_user
 */
class m200128_123914_add_columns_access_token_and_expire_at_to_user extends Migration
{

    private $tableName = '{{%user}}';
    private $columns = [
        "access_token", "expire_at"
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }

        foreach ($this->columns as $column) {
            if (isset($table->columns[$column])) {
                User::updateAll([$column => null]);
            } else {
                $this->addColumn($this->tableName, $column, $this->string()->defaultValue(null));
            }
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }

        foreach ($this->columns as $column) {
            if (isset($table->columns[$column])) {
                $this->dropColumn($this->tableName, $column);
            }
        }

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200128_123914_add_columns_access_token_and_expire_at_to_user cannot be reverted.\n";

        return false;
    }
    */
}
