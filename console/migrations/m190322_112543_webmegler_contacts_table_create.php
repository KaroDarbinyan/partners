<?php

use yii\db\Migration;

/**
 * Class m190322_112543_webmegler_contacts_table_create
 */
class m190322_112543_webmegler_contacts_table_create extends Migration
{
    private $tableName = '{{%webmegler_contacts}}';

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
            file_get_contents('frontend/web/requests/contacts_contacts.json' ),
            true
        );
        $fields = [
            'id__' => $this->primaryKey()
        ];

        foreach (array_values($attrs)[0][0] as $name => $attr) {

            $fields[$name] = is_array($attr) ?
                $this->string(1024) :
                $this->char(255)
            ;
        }
        $this->createTable($this->tableName, $fields, $tableOptions);

        foreach ($attrs as $i => $row) {
            $row = $row[0];// $row[0] because of the structure of json in file
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
        echo "m190320_113953_webmegler_contacts_table_create cannot be reverted.\n";

        return false;
    }
    */
}
