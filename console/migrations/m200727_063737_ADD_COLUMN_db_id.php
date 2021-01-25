<?php

use yii\db\Migration;

/**
 * Class m200727_063737_ADD_COLUMN_db_id
 */
class m200727_063737_ADD_COLUMN_db_id extends Migration
{
    private $tableName = "department";
    private $tables = [
        'free_text' => "propertyDetailId",
        'image' => "propertyDetailId",
        'docs' => "property_web_id",
        'property_neighbourhood' => "property_web_id",
        'property_visits' => "property_web_id",
        'property_links' => "property_web_id",
        'criterias' => "property_web_id",
    ];

    private function getColumns(){
        return [
            "databasenummer" => $this->integer(4),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->tables as $tableName => $columnName) {
            $table = $this->db->getTableSchema($tableName, true);
            if (!$table) {
                echo "Table {$tableName} dose not exist \n";
                return;
            }
            foreach ($this->getColumns() as $name=>$type) {
                if(isset($table->columns[$name])) {
                    $this->dropColumn($tableName, $name);
                }
                $this->addColumn($tableName, $name, $type);
            }

            $this->execute("
              UPDATE {$tableName}
              INNER join property_details on {$tableName}.{$columnName} = property_details.web_id 
              SET {$tableName}.databasenummer = property_details.databasenummer
              where property_details.id IS NOT NULL
            ");
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
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }
    }
}
