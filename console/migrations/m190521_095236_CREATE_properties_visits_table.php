<?php

use yii\db\Migration;
use console\controllers\WebmeglerController;
use common\models\Property;
/**
 * Class m190521_095236_CREATE_properties_visits_table
 */
class m190521_095236_CREATE_properties_visits_table extends Migration
{
    private $tableName = "{{%property_visits}}";
    private $parentTableName = "{{%property}}";
    private $fileName = 'frontend/web/requests/data.json';
    private $data;

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
            'nr'       => $this->integer(),
            'visit_id' => $this->integer(),
            'fra'      => $this->timestamp(),
            'til'      => $this->string(),
            'property_web_id' => $this->integer(),
        ],$tableOptions);

        $this->addForeignKey(
            "property_visits",
            $this->tableName,
            "property_web_id",
            $this->parentTableName,
            "web_id"
        );
        $this->data = json_decode(
            file_get_contents( $this->fileName ),
            true
        )['eneiendom'];
        foreach($this->data as $property) {
            /** @var Property $property */
            echo "Property insert: {$property['id']}\n";
            WebmeglerController::updateVisits(
                $property,
                Property::findOne(['web_id' => $property['id']])
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

}
// Sample
/*"visninger": [
    {
        "visning": [
            {
                "nr": "1",
                "id": "3384004",
                "fra": "12.05.2019 13:00",
                "til": "12.05.2019 14:00"
            },
            {
                "nr": "2",
                "id": "3385097",
                "fra": "13.05.2019 19:00",
                "til": "13.05.2019 20:00"
            }
        ]
    }
],*/