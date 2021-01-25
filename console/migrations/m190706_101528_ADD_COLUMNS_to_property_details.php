<?php

use yii\db\Migration;

/**
 * Class m190706_101528_ADD_COLUMNS_to_property_details
 */
class m190706_101528_ADD_COLUMNS_to_property_details extends Migration
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
            if (isset($table->columns[$columnName]) || is_array($v)){continue;}

            $this->addColumn(
                $this->tableName,
                $columnName,
                "LONGTEXT"
            );
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
