<?php

use yii\db\Migration;

/**
 * Class m200306_104628_USER_set_department_id_equal_id_avdelinger
 */
class m200306_104628_USER_set_department_id_equal_id_avdelinger extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute( "UPDATE " . \common\models\User::tableName() . " SET department_id = id_avdelinger;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200306_104628_USER_set_department_id_equal_id_avdelinger cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200306_104628_USER_set_department_id_equal_id_avdelinger cannot be reverted.\n";

        return false;
    }
    */
}
