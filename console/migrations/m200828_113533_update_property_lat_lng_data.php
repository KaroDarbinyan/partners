<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m200819_125226_update_property_lat_lng_data
 */
class m200828_113533_update_property_lat_lng_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        PropertyDetails::updateAll(["lat" => null, "lng" => null], ["lat" => 1000, "lng" => 1000]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        PropertyDetails::updateAll(["lat" => 1000, "lng" => 1000], ["lat" => null, "lng" => null]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200819_125226_update_property_lat_lng_data cannot be reverted.\n";

        return false;
    }
    */
}
