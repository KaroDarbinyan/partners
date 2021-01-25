<?php

use yii\db\Migration;

/**
 * Class m200120_072856_ADD_COMPOSITE_INDEX_to_free_text
 */
class m200120_072856_ADD_COMPOSITE_INDEX_to_free_text extends Migration
{
    private $tableName = "free_text";

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
        $this->createIndex('unique_index_from_source',
            $this->tableName,
            ['propertyDetailId', 'compositeTextId'],
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
    }


}