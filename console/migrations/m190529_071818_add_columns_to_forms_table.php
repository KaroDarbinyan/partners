<?php

use yii\db\Migration;

/**
 * Class m190529_071818_add_columns_to_forms_table
 */
class m190529_071818_add_columns_to_forms_table extends Migration
{
    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!isset($table->columns['url_token'])) $this->addColumn($this->tableName, 'url_token', $this->string());
        if (!isset($table->columns['employee_web_id'])) $this->addColumn($this->tableName, 'employee_web_id', $this->string());
        if (!isset($table->columns['broker_id'])) $this->addColumn($this->tableName, 'broker_id', $this->string());
        if (!isset($table->columns['employee_phone'])) $this->addColumn($this->tableName, 'employee_phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table->columns['url_token'])) $this->dropColumn($this->tableName, 'url_token');
        if (isset($table->columns['employee_web_id'])) $this->dropColumn($this->tableName, 'employee_web_id');
        if (isset($table->columns['broker_id'])) $this->dropColumn($this->tableName, 'broker_id');
        if (isset($table->columns['employee_phone'])) $this->dropColumn($this->tableName, 'employee_phone');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190529_071818_add_columns_to_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
