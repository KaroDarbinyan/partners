<?php

use yii\db\Migration;

/**
 * Class m190402_122432_create_table_webmagler_free_text
 */
class m190402_122432_create_table_webmagler_free_text extends Migration
{
    private $tableName = '{{%webmagler_free_text}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $tableOptions = $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : NULL;
        $attrs = json_decode(file_get_contents('frontend/web/requests/properties_eiendommer.json'), true);
        $attrs = $attrs['eneiendom'][0]['fritekster'][0]['fritekst'][0];
        $fields = [
            'id__' => $this->primaryKey(),
            'propertyDetailId' => $this->integer(),
        ];

        foreach ($attrs as $name => $attr) {
            $fields[$name] = $this->string();
        }

        $this->createTable($this->tableName, $fields, $tableOptions);
        $this->addForeignKey(
            "property_detail_to_free_text",
            $this->tableName,
            "propertyDetailId",
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
