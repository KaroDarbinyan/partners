<?php

use yii\db\Migration;

/**
 * Class m191211_103653_alter_forms_table
 */
class m191211_103653_alter_forms_table extends Migration
{

    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if ($table && isset($table->columns['url_token']) && !isset($table->columns['url'])) {
            $this->renameColumn($this->tableName, 'url_token', 'token');
            $this->addColumn($this->tableName, 'url', $this->string());
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if ($table) {
            if (isset($table->columns['token'])) {
                $this->renameColumn($this->tableName, 'token', 'url_token');
            }
            if (isset($table->columns['url'])) {
                $this->dropColumn($this->tableName, 'url');
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
        echo "m191211_103653_alter_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
