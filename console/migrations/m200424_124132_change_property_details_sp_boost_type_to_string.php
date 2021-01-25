<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m200424_124132_change_property_details_sp_boost_type_to_string
 */
class m200424_124132_change_property_details_sp_boost_type_to_string extends Migration
{
    private $tableName = "{{%property_details}}";

    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table) && isset($table->columns['sp_boost'])) {
            $this->alterColumn($this->tableName, 'sp_boost', $this->string());
            PropertyDetails::updateAll(["sp_boost" => null]);
        }

    }

    public function down()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table) && isset($table->columns['sp_boost'])) {
            $this->alterColumn($this->tableName, 'sp_boost', $this->boolean()->defaultValue(false));
            PropertyDetails::updateAll(["sp_boost" => false]);
        }
    }
}
