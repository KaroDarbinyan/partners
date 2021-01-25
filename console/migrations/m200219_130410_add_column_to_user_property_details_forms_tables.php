<?php

use yii\db\Migration;

/**
 * Class m200219_130410_add_column_to_user_property_details_forms_tables
 */
class m200219_130410_add_column_to_user_property_details_forms_tables extends Migration
{
    private $tables = [
        '{{%user}}',
        '{{%property_details}}',
        '{{%forms}}'
    ];
    private $column = "firebase_id";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->tables as $tableName) {
            $table = $this->db->getTableSchema($tableName, true);
            if (!$table) {
                echo "Table {$tableName} dose not exist \n";
            }
            if (!isset($table->columns[$this->column])) {
                $this->addColumn($tableName, $this->column, $this->string()->defaultValue(null));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->tables as $tableName) {
            $table = $this->db->getTableSchema($tableName, true);
            if (!$table) {
                echo "Table {$tableName} dose not exist \n";
            }
            if (isset($table->columns[$this->column])) {
                $this->dropColumn($tableName, $this->column);
            }
        }
    }
}
