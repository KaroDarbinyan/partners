<?php

use yii\db\Migration;

/**
 * Class m190923_080218_DROP_COLUMN_property_neighbourhood_percent_text_data
 */
class m190923_080218_DROP_COLUMN_property_neighbourhood_percent_text_data extends Migration
{

    private $tableName = '{{%property_neighbourhood}}';
    private $columnName = 'percent_text_data';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table){
            echo "\ntable Does Not Exists \n";
            return false;
        }
        if (isset($table->columns[$this->columnName])){
            $this->dropColumn($this->tableName, $this->columnName);
        }else{
            echo "\n Column not Exists \n";
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table){
            echo "\n table Does Not Exists \n";
            return true;
        }
        if (isset($table->columns[$this->columnName])){
            echo "\n Column Already Exists \n";
        }else{
            $this->addColumn($this->tableName, $this->columnName, $this->text());
        }

    }
}
