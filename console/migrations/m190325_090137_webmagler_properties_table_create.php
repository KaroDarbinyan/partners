<?php

use yii\db\Migration;

/**
 * Class m190325_090137_webmagler_properties_table_create
 */
class m190325_090137_webmagler_properties_table_create extends Migration
{
    private $tableName = '{{%webmegler_properties}}';
    private $fileName = 'frontend/web/requests/properties_eiendommer.json';

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
            file_get_contents( $this->fileName ),
            true
        )['eneiendom'];

        $fields = [
            'id__' => $this->primaryKey()
        ];

        foreach ($attrs[0] as $name => $attr) {// TODO: find better solution
            $fields[str_replace('-', '_', $name)] = 'LONGTEXT';
        }
        $this->createTable($this->tableName, $fields, $tableOptions);
        foreach ($attrs as $i => $row) {
            foreach ($row as $name => $column) {
                $replaceName = str_replace('-', '_', $name);
                if (!isset($fields[$replaceName])){
                    $this->addColumn($this->tableName, $replaceName, 'LONGTEXT');
                    $fields[$replaceName] = 'LONGTEXT';
                }
                $row[$replaceName] = is_array($column) ? json_encode($column) : $column;
                $row[$replaceName] = strlen($row[$replaceName]) > 256 ?
                    "very long " . (is_array($column) ? "Array" : "String") : $row[$replaceName];
                $rowName = $row[$name];
                unset($row[$name]);
                $row[$replaceName] = $rowName; // TODO: Fix HardCoded code
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
        echo "m190325_090137_webmagler_properties_table_create cannot be reverted.\n";

        return false;
    }
    */
}
