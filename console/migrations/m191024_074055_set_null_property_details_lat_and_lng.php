<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m191024_074055_set_null_property_details_lat_and_lng
 */
class m191024_074055_set_null_property_details_lat_and_lng extends Migration
{

    private $tableName = '{{%property_details}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['lat']) && !isset($table->columns['lng'])) {
            return false;
        }
        PropertyDetails::updateAll(['lat' => null, 'lng' => null]);
        return true;

    }

    /**
     * {@inheritdoc}
     */
    public
    function safeDown()
    {
        echo "m191024_074055_set_null_property_details_lat_and_lng reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_074055_set_null_property_details_lat_and_lng cannot be reverted.\n";

        return false;
    }
    */
}
