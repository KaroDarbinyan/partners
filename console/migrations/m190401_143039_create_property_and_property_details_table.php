<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_and_property_details}}`.
 */
class m190401_143039_create_property_and_property_details_table extends Migration
{
    private $tableName = '{{%property}}';
    private $childTableName = '{{%property_details}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->execute("SET foreign_key_checks = 0;");
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        if ($this->db->getTableSchema( $this->childTableName, true ) !== null) {
            $this->dropTable($this->childTableName);
        }

        $options = [
            'id' => $this->primaryKey(),
            'address' => $this->text(),//Avdeling Besoksadresse
            'price' => $this->float(20),//Prissamletsum
            'type' => $this->char(255),//Type Eiendomstyper
            's_meters' => $this->integer(),//Bruttoareal
        ];

        $childOptions = [
            'id' => $this->primaryKey(),
            'propertyId' => $this->integer(),
        ];

        $this->createTable($this->tableName, $options, $tableOptions);
        $this->createTable($this->childTableName, $childOptions, $tableOptions);
        $this->addForeignKey(
            "property_to_details",
            $this->childTableName,
            "propertyId",
            $this->tableName,
            "id"
        );


        $this->execute("SET foreign_key_checks = 1;");
        $this->extractAndImport();

    }

    /**
     * Extract data data tables ando import to correct ones
     */
    public function extractAndImport(){
        $q = new \yii\db\Query();
        $properties = $q->select([
            'avdeling_besoksadresse',
            'prissamletsum',
            'type_eiendomstyper',
            'bruttoareal',
            'fritekster',
        ])
          ->from('{{%webmegler_properties}}')
          ->all();


        foreach ($properties as $property) {
            $row = [
                'address' => $property['avdeling_besoksadresse'],
                'price' => $property['prissamletsum'],
                'type' => $property['type_eiendomstyper'],
                's_meters' => $property['bruttoareal'],
            ];
            $this->insert ( $this->tableName, $row );
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("SET foreign_key_checks = 0;");
        if ($this->db->getTableSchema( $this->childTableName, true ) !== null) {
            $this->dropTable($this->childTableName);
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $this->execute("SET foreign_key_checks = 1;");
    }
}
