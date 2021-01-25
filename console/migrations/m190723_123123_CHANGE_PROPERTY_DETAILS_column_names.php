<?php

use yii\db\Migration;

/**
 * Class m190723_123123_CHANGE_PROPERTY_DETAILS_column_names
 */
class m190723_123123_CHANGE_PROPERTY_DETAILS_column_names extends Migration
{
    private $tableName = "property_details";
    private $file = "custom_gets/property-sample.json";

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

        $data = json_decode(file_get_contents($this->file), true)['eneiendom'][0];
        foreach ($data as $columnName => $v) {
            $oldName = str_replace('-', '_', $columnName);
            $newName = str_replace('-', '__', $columnName);
            if (
                isset($table->columns[$newName])
                || is_array($v)
                || isset($table->columns[$columnName])
                && strpos($columnName, '-') === false
            ){continue;}
            $oldName = strpos($columnName, '-') === false ? $oldName : $columnName;
            if($oldName != $newName && isset($table->columns[$oldName]) ){
                $this->renameColumn(
                    $this->tableName,
                    $oldName,
                    $newName
                );
            }else{
                $this->addColumn(
                    $this->tableName,
                    $newName,
                    "LONGTEXT"
                );
            }
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190706_101528_ADD_COLUMNS_to_property_details Migration is unable to be reverted \n";
    }


}
