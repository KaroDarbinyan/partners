<?php

use yii\db\Migration;

/**
 * Class m190423_101840_RE_INSERT_Docs_table
 */
class m190423_101840_RE_INSERT_Docs_table extends Migration
{
    private $tableName = '{{%docs}}';
    private $fileName = 'frontend/web/requests/data.json';
    private $data = [];
    private $fields = array();
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->data = json_decode(
            file_get_contents( $this->fileName ),
            true
        )['eneiendom'];

        $this->createInsertDocs();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }

    /**
     * Create property and property_details tables and insert property_details Table
     */
    private function createInsertDocs(){
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $properties = $this->data;
        $this->fields = array(
            'id' => $this->primaryKey(),
        );
        $this->createTable($this->tableName, $this->fields, $tableOptions);

        /**
         * Insert Data in Docs
         */
        foreach ($properties as $i => $property) {
            $this->insertDocuments('dokumenter', $property);
            $this->insertDocuments('alledokumenter', $property);
        }
    }

    /**
     * Isert all documents with specific key
     * @param $keyName string key of documents in huge json
     * @param $property array property which belongs douments
     */
    private function insertDocuments($keyName, $property){
        if(!count($property[$keyName]) || !isset($property[$keyName][0]['dokument'])){
            return;
        }
        foreach ($property[$keyName][0]['dokument'] as $document) {
            // NOTE: Setup Primary key
            $document['doc_id'] = $document['id'];
            $document['property_web_id'] = $property['id'];
            unset($document['id']);

            // NOTE: Collect data and add untracked columns
            foreach ($document as $name => $column) {
                $replaceName = str_replace('-', '_', $name);

                if (!isset($this->fields[$replaceName])){
                    $this->addColumn($this->tableName, $replaceName, 'LONGTEXT');
                    $this->fields[$replaceName] = 'LONGTEXT';
                }
                $document[$replaceName] = is_array($column) ? json_encode($column) : $column;
                $buff = $document[$name];
                unset($document[$name]);
                $document[$replaceName] = $buff;
            }
            $this->insert ( $this->tableName, $document );
        }
    }

}

