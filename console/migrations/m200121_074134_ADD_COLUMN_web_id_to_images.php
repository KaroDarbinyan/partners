<?php

use yii\db\Migration;

/**
 * Class m200121_074134_ADD_COLUMN_web_id_to_images
 */
class m200121_074134_ADD_COLUMN_web_id_to_images extends Migration
{
    private $tableName = "image";
    private function getColumns(){
        return [
            "web_id"=> $this->integer(10),
        ];
    }

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
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
        }

        $this->createIndex('unique_index_from_source',
            $this->tableName,
            ['propertyDetailId', 'web_id'],
            true
        );
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
        $this->dropIndex('unique_index_from_source', $this->tableName);
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }

        }
    }
}