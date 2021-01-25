<?php

use yii\db\Migration;

/**
 * Class m190423_090104_CREATE_docs_table_for_property
 */
class m190423_090104_CREATE_docs_table_for_property extends Migration
{
    private $tableName = '{{%docs}}';
    private $fileName = 'frontend/web/requests/data.json';
    private $data = [];
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

        $propertys = $this->data;
        $fields = array(
            'id' => $this->primaryKey(),
        );
        $this->createTable($this->tableName, $fields, $tableOptions);

        /**
         * Insert Data in property_details
         */
        foreach ($propertys as $i => $property) {
            if(!count($property['dokumenter']) || !isset($property['dokumenter'][0]['dokument'])){
                continue;
            }
            $document = [];
            foreach ($property['dokumenter'][0]['dokument'] as $document) {
                // NOTE: Setup Primary key
                $document['doc_id'] = $document['id'];
                $document['property_web_id'] = $property['id'];
                unset($document['id']);

                // NOTE: Collect data and add untracked columns
                foreach ($document as $name => $column) {
                    $replaceName = str_replace('-', '_', $name);
                    if (!isset($fields[$replaceName])){
                        $this->addColumn($this->tableName, $replaceName, 'LONGTEXT');
                        $fields[$replaceName] = 'LONGTEXT';
                    }
                    $document[$replaceName] = is_array($column) ? json_encode($column) : $column;
                    $buff = $document[$name];
                    unset($document[$name]);
                    $document[$replaceName] = $buff;
                }
            }
            $this->insert ( $this->tableName, $document );
        }
    }
}
