<?php

use yii\db\Migration;

/**
 * Class m200924_140646_change_property_details_forventet_salgspris_type_to_string
 */
class m200924_140646_change_property_details_forventet_salgspris_type_to_string extends Migration
{
    private $tableName = "{{%property_details}}";

    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table) && isset($table->columns['forventet_salgspris']))
            $this->alterColumn($this->tableName, 'forventet_salgspris', $this->string());
    }

    public function down()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table) && isset($table->columns['forventet_salgspris']))
            $this->alterColumn($this->tableName, 'forventet_salgspris', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200924_140646_change_property_details_forventet_salgspris_type cannot be reverted.\n";

        return false;
    }
    */
}
