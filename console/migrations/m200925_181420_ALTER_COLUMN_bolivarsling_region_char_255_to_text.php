<?php

use yii\db\Migration;

/**
 * Class m200925_181420_ALTER_COLUMN_bolivarsling_region_char_255_to_text
 */
class m200925_181420_ALTER_COLUMN_bolivarsling_region_char_255_to_text extends Migration
{
    private $tableName = '{{%boligvarsling}}';
    private $columnName = 'region';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if ($table && isset($table->columns[$this->columnName])){
            $this->alterColumn($this->tableName, $this->columnName, $this->text());
        }else{
            echo "table {$this->tableName} or column {$this->columnName} dose NOt exist \n";
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if ($table && isset($table->columns[$this->columnName])){
            $this->alterColumn($this->tableName, $this->columnName, $this->char(255));
        }else{
            echo "table {$this->tableName} or column {$this->columnName} dose NOt exist \n";
            return false;
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190820_092503_changeformd_table_post_number_calumn_to_int cannot be reverted.\n";

        return false;
    }
    */
}
