<?php

use yii\db\Migration;

/**
 * Class m190702_081835_ADD_COLUMN_area_to_all_post_numbers
 */
class m190702_081835_ADD_COLUMN_area_to_all_post_numbers extends Migration
{
    private $tableName = "all_post_number";
    private $secondTableName = "property_details";
    private $columnName = "area";
    private $file = "webmegler-data/bydel-oslo.csv";
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
        if(!isset($table->columns[$this->columnName])) {
            $this->addColumn($this->tableName, $this->columnName, $this->string());
        }

        $data = file_get_contents($this->file);
        $data = explode("\n", $data);
        foreach ($data as $i => $d) {
            $data[$i] = explode(';', $d);
            if (count($data[$i]) !== 3){
                continue;
            }
            $this->update(
                $this->tableName,
                [$this->columnName => $data[$i][1]],
                ['index'=> $data[$i][0]]
            );
        }

        $c = count($data);
        foreach ($data as $i => $d) {
            if (count($data[$i]) !== 3){
                continue;
            }
            echo "{$data[$i][0]} : {$data[$i][1]} :: {$c}:{$i} \n";

            $this->update(
                $this->secondTableName,
                [$this->columnName => $data[$i][1]],
                ['postnummer'=> $data[$i][0]]
            );
        }
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
