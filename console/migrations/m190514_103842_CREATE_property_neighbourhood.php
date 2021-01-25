<?php

use yii\db\Migration;
use common\models\Property;
use console\controllers\WebmeglerController;

/**
 * Class m190514_103842_CREATE_property_neighbourhood
 */
class m190514_103842_CREATE_property_neighbourhood extends Migration
{
    private $tableName = "{{%property_neighbourhood}}";
    private $parentTableName = "{{%property}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = "";
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $this->createTable( $this->tableName, [
            'id'       => $this->primaryKey()->notNull(),
            'type'     => $this->string(),
            'name'     => $this->string(),
            'distance' => $this->float(),
            'property_web_id' => $this->integer(),
        ],$tableOptions);
        $this->addForeignKey(
            "property_neighbors",
            $this->tableName,
            "property_web_id",
            $this->parentTableName,
            "web_id"
        );

        $properties = Property::find()
            ->joinWith('propertyNeighborDoc')
            ->where(['not', ['docs.id' => null]])
            ->all()
        ;

        foreach($properties as $property) {
            /** @var Property $property */
            echo "Property insert: {$property->web_id}\n";
            WebmeglerController::updateNeighbours(
                $property->propertyNeighborDoc->urldokument,
                $property
            );
        }
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190514_103842_CREATE_property_neighbourhood cannot be reverted.\n";

        return false;
    }
    */
}
