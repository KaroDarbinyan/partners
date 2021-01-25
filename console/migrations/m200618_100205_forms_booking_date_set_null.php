<?php

use common\models\Forms;
use yii\db\Migration;

/**
 * Class m200618_100205_forms_booking_date_set_null
 */
class m200618_100205_forms_booking_date_set_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $updateCount = Forms::updateAll(["booking_date" => null]);

        echo "updated: {$updateCount} elements";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200618_100205_forms_booking_date_set_null cannot be reverted.\n";

        return false;
    }
    */
}
