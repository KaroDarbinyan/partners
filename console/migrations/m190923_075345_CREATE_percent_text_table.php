<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%percent_text}}`.
 */
class m190923_075345_CREATE_percent_text_table extends Migration
{
    private $tableName = '{{%percent_text}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $tableOptions = $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : NULL;
        $fields = [
            'id' => $this->primaryKey(),
            'number' => $this->integer(),// id in xml(json) file
            'name' => $this->char(255),
            'value' => $this->integer(3),
            'property_web_id' => $this->integer(),
        ];
        $this->createTable($this->tableName, $fields, $tableOptions);
        $this->addForeignKey(
            "property_detail_to_percent_text",
            $this->tableName,
            "property_web_id",
            '{{%property_details}}',
            "id"
        );
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190402_122432_create_table_webmagler_free_text cannot be reverted.\n";

        return false;
    }
    */
}
