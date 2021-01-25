<?php

use yii\db\Migration;

/**
 * Class m190325_082601_webmegler_employees_table_create
 */
class m190325_082601_webmegler_employees_table_create extends Migration
{
    private $tableName = '{{%webmegler_employees}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $attrs = json_decode(
            file_get_contents('frontend/web/requests/employees_ansatte.json' ),
            true
        )['ansatt'];

        $fields = [
            'id__' => $this->primaryKey()
        ];

        foreach ($attrs[1] as $name => $attr) {// TODO: find better solution

            $fields[$name] = is_array($attr) ?
                $this->string(1024) :
                $this->char(255)
            ;
        }
        $this->createTable($this->tableName, $fields, $tableOptions);
        foreach ($attrs as $i => $row) {
            foreach ($row as $name => $column) {
                $row[$name] = is_array($column) ? json_encode($column) : $column;
            }
            $this->insert ( $this->tableName, $row );

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190325_082601_webmegler_employees_table_create cannot be reverted.\n";

        return false;
    }
    */
}
