<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m190626_070404_ADD_street_column_to_property_details
 */
class m190626_070404_ADD_street_column_to_property_details extends Migration
{
    private $tableName = "property_details";
    private $columnName = "street";
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
        if(isset($table->columns[$this->columnName])) {
            $this->dropColumn($this->tableName, $this->columnName);
        }
        $this->addColumn($this->tableName, $this->columnName, $this->string());
        $specChars = explode(' ','Å Ø Æ å ø æ');
        $sourceColumn = 'adresse';
        $correctSource = $sourceColumn;
        foreach ($specChars as $c) {
            $correctSource = "REPLACE({$correctSource}, '{$c}', '*')";
        }
        $this->execute("
          UPDATE {$this->tableName}
          SET {$this->columnName} = SUBSTR(
            {$sourceColumn}, 1,
            LENGTH({$correctSource}) - REGEXP_INSTR(REVERSE({$correctSource}),'[0-9] ')
          ) 
          WHERE {$sourceColumn} IS NOT NULL
        ");

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
        if(!isset($table->columns[$this->columnName])) {
            echo "Column {$this->tableName}.{$this->columnName} dose not exists \n";
            return;
        }
        $this->dropColumn($this->tableName, $this->columnName);
    }


}
