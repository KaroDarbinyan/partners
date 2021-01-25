<?php

use common\models\UserAktiviteter;
use yii\db\Migration;

/**
 * Class m191014_114740_delete_user_aktivitetrer_all_data
 */
class m191014_114740_delete_user_aktivitetrer_all_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        UserAktiviteter::deleteAll();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191014_114740_delete_user_aktivitetrer_all_data cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191014_114740_delete_user_aktivitetrer_all_data cannot be reverted.\n";

        return false;
    }
    */
}
