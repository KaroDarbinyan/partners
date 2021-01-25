<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner_settings}}`.
 */
class m200511_082002_create_partner_settings_table extends Migration
{

    private $tableName = '{{%partner_settings}}';
    private $propertyTableName = '{{%property_details}}';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        if (($propTable = $this->db->getTableSchema($this->propertyTableName, true)) !== null) {
            if (isset($propTable->columns["is_visible"])) {
                $this->alterColumn($this->propertyTableName, "is_visible", $this->boolean()->defaultValue(true));
                PropertyDetails::updateAll(["is_visible" => true], ["is_visible" => null]);
            }
        }

        $fields = [
            'id' => $this->primaryKey(),
            'property_view' => $this->text(),
            'active' => $this->boolean()->defaultValue(true),
            'partner_id' => $this->integer()->notNull(),
        ];

        $this->createTable($this->tableName, $fields, $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        if (($propTable = $this->db->getTableSchema($this->propertyTableName, true)) !== null) {
            if (isset($propTable->columns["is_visible"])) {
                $this->alterColumn($this->propertyTableName, "is_visible", $this->boolean());
                PropertyDetails::updateAll(["is_visible" => null]);
            }
        }

    }
}
