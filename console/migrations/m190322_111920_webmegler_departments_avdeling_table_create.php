<?php

use yii\db\Migration;

/**
 * Class m190322_111920_webmegler_departments_avdeling_table_create
 */
class m190322_111920_webmegler_departments_avdeling_table_create extends Migration
{

    private $tableName = '{{%departments_avdeling}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $attrs = json_decode( file_get_contents('frontend/web/requests/department_avdelinger.json' ), true);
        $fields = [
            'id__' => $this->primaryKey()
        ];

        foreach ($attrs['avdeling'][0] as $name => $attr) {
            $fields[$name] = is_array($attr) ?
                $this->string(1024) :
                $this->char(255)
            ;
        }

        $this->createTable($this->tableName, $fields, $tableOptions);

        foreach ($attrs['avdeling'] as $i => $row) {
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
        echo "m190320_130324_webmegler_departments_avdeling_table_create cannot be reverted.\n";

        return false;
    }
    */
}
