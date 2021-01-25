<?php

use yii\db\Migration;

/**
 * Class m190409_062123_CREATE_property_table_with_child_tables
 */
class m190409_062123_CREATE_property_table_with_child_tables extends Migration
{
    private $tableName = '{{%property}}';
    private $detailTableName = '{{%property_details}}';
    private $textTableName = '{{%free_text}}';
    private $imageTableName = '{{%image}}';
    private $fileName = 'frontend/web/requests/properties_eiendommer.json';
    private $propertyFiledsMap = [
            'web_id' => 'id',
            'address' => 'avdeling_besoksadresse',
            'price' => 'prissamletsum',
            'type' => 'type_eiendomstyper',
            's_meters' => 'bruttoareal',
    ];
    private $propertyExceptions = [
        'totalkostnadsomtekst',
    ];
    private $data = [];
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->data = json_decode(
            file_get_contents( $this->fileName ),
            true
        )['eneiendom'];
        $this->execute("SET foreign_key_checks = 0;");

        $this->createInsertPropertyAndDetails();
        $this->insertPropertyTable();
        $this->createInitFreeTextTable();
        $this->createInitImageTable();

        $this->execute("SET foreign_key_checks = 1;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->execute("SET foreign_key_checks = 0;");
            $this->dropTable($this->tableName);
            $this->execute("SET foreign_key_checks = 1;");
        }
    }

    /**
     * Insert property table
     */
    private function insertPropertyTable(){
        foreach ($this->data as $dataRow) {
            $row = [];
            foreach ($this->propertyFiledsMap as $key => $jsonKey) {
                $row[$key] = isset($dataRow[$jsonKey]) ? $dataRow[$jsonKey] : NULL;
            }
            $this->insert ( $this->tableName, $row );
        }
    }

    /**
     * Create and insert free texts table
     */
    private function createInitFreeTextTable(){
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->textTableName, true) !== null) {
            $this->dropTable($this->textTableName);
        }
        $attrs = $this->data;
        $fields = [
            'id' => $this->primaryKey(),
            'propertyDetailId' => $this->integer(),
        ];

        foreach ($attrs[0]['fritekster'][0]['fritekst'][0] as $name => $attr) {
            $fields[$name] = $this->string();
        }

        $this->createTable($this->textTableName, $fields, $tableOptions);
        $this->addForeignKey(
            "detail_to_free_text",
            $this->textTableName,
            "propertyDetailId",
            $this->detailTableName,
            "id"
        );

        foreach ($attrs as $i => $row) {

            foreach ($row['fritekster'][0]['fritekst'] as $textObj) {
                $insertRow = [
                    'propertyDetailId' => $row['id'],
                ];
                foreach ($textObj as $name => $column) {
                    if (!isset($fields[$name])){
                        $this->addColumn($this->textTableName, $name, 'LONGTEXT');
                        $fields[$name] = 'LONGTEXT';
                    }
                    $insertRow[$name] = $column;
                }
                $this->insert ( $this->textTableName, $insertRow );
            }
        }


    }

    /**
     * Create and insert image table
     */
    private function createInitImageTable(){
        $tableOptions = '';
        $tableName = $this->imageTableName;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($tableName, true) !== null) {
            $this->dropTable($tableName);
        }
        $attrs = $this->data;

        $fields = [];
        foreach ($attrs[0]['bilder'][0]['bilde'][0] as $name => $attr) {
            $fields[$name] = $this->string();
        }
        $fields['id'] = $this->primaryKey();
        $fields['propertyDetailId'] = $this->integer();

        $this->createTable($tableName, $fields, $tableOptions);
        $this->addForeignKey(
            "detail_to_image",
            $tableName,
            "propertyDetailId",
            $this->detailTableName,
            "id"
        );
        foreach ($attrs as $i => $row) {

            foreach ($row['bilder'][0]['bilde'] as $imageObj) {
                $insertRow = [
                    'propertyDetailId' => $row['id'],
                ];
                foreach ($imageObj as $name => $column) {
                    if (!array_key_exists ($name, $fields)){
                        $this->addColumn($tableName, $name, 'LONGTEXT');
                        $fields[$name] = 'LONGTEXT';
                    }
                    $insertRow[$name] = $column;
                }
                $this->insert( $tableName, $insertRow );
            }
        }


    }

    /**
     * Create property and property_details tables and insert property_details Table
     */
    private function createInsertPropertyAndDetails(){
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        if ($this->db->getTableSchema($this->detailTableName, true) !== null) {
            $this->dropTable($this->detailTableName);
        }


        $attrs = $this->data;

        $fields = [
            'id' => $this->primaryKey(),
            'web_id' => $this->integer(),
            'address' => $this->text(),//Avdeling Besoksadresse
            'price' => $this->float(20),//Prissamletsum
            'type' => $this->char(255),//Type Eiendomstyper
            's_meters' => $this->integer(),//Bruttoareal
        ];
        $this->createTable($this->tableName, $fields, $tableOptions);

        $fields = [];
        foreach ($attrs[0] as $name => $attr) {// TODO: find better solution
            $fields[str_replace('-', '_', $name)] = 'LONGTEXT';
        }
        $fields['id'] = $this->primaryKey();
        $this->createTable($this->detailTableName, $fields, $tableOptions);
        $this->addForeignKey(
            "property_to_details",
            $this->tableName,
            "web_id",
            $this->detailTableName,
            "id"
        );
        /**
         * Insert Data in property_details
         */
        foreach ($attrs as $i => $row) {
            foreach ($row as $name => $column) {
                $replaceName = str_replace('-', '_', $name);
                if (!isset($fields[$replaceName])){
                    $this->addColumn($this->detailTableName, $replaceName, 'LONGTEXT');
                    $fields[$replaceName] = 'LONGTEXT';
                }
                $row[$replaceName] = is_array($column) ? json_encode($column) : $column;
                $row[$replaceName] = (
                    strlen($row[$replaceName]) > 256 &&
                    !in_array($replaceName, $this->propertyExceptions)
                ) ? "very long " . (is_array($column) ? "Array" : "String") : $row[$replaceName];
                $buff = $row[$name];
                unset($row[$name]);
                $row[$replaceName] = $buff;
            }
            $this->insert ( $this->detailTableName, $row );
        }
    }
}
