<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m190701_070335_CHANGE_property_details_markedsforingsdato_column_type_to_int_11
 */
class m190701_070335_CHANGE_property_details_markedsforingsdato_column_type_to_int_11 extends Migration
{
    private $tableName = "property_details";
    private $columnName = "markedsforingsdato";
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
            echo "{$this->tableName}.{$this->columnName} column is missing \n";
            return;
        }
        $props = (new \yii\db\Query())
            ->select(['id', $this->columnName])
            ->from($this->tableName)
            ->where(['not', [$this->columnName => 0],])
            ->limit(10)
            ->all();

        foreach ($props as $p) {
            $this->update(
                $this->tableName,
                [$this->columnName => strtotime($p[$this->columnName])],
                ['id' => $p['id']]
            );
        }

        $sql = "UPDATE {$this->tableName}
            SET {$this->columnName} = 
            CASE WHEN {$this->columnName} IS NULL THEN 0
            ELSE {$this->columnName} END;
        ";
        $this->execute($sql);
        $this->alterColumn($this->tableName, $this->columnName, $this->integer(11)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190701_070335_CHANGE_property_details_markedsforingsdato_column_type_to_int_11 cannot be reverted \n";
    }


}
