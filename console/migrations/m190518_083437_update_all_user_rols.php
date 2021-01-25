<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m190517_115655_update_all_user_rols
 */
class m190518_083437_update_all_user_rols extends Migration
{

    private $tableName = '{{%user}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->update($this->tableName, ['role' => 'broker']);
            $this->update($this->tableName, ['role' => 'superadmin'],['username'=>3000216]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->update($this->tableName, ['role' => null]);
            $this->update($this->tableName, ['role' => 'superadmin'],['username'=>3000216]);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190517_115655_update_all_user_rols cannot be reverted.\n";

        return false;
    }
    */
}
