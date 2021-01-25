<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news_links}}`.
 */
class m200708_184522_add_description_column_to_news_links_table extends Migration
{
    private $tableName = "{{%news_links}}";

    private function getColumns()
    {
        return [
            "file_desc" => $this->string(),
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
        foreach ($this->getColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
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
        foreach ($this->getColumns() as $name => $type) {
            if (isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }

    }
}
