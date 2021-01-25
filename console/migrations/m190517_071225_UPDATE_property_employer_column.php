<?php

use yii\db\Migration;
use common\models\Property;
use common\models\User;

/**
 * Class m190517_071225_UPDATE_property_employer_column
 */
class m190517_071225_UPDATE_property_employer_column extends Migration
{
    private $tableName = '{{%property}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->tableName, true) == null) {
            echo "Table is missing\n";
            return false;
        }
        $props = Property::find()->
            joinWith('propertyDetails')->
            all()
        ;
        foreach ($props as $prop) {
            /** @var Property $prop */
            echo "Property: {$prop->web_id}\n";
            $uId = $prop->propertyDetails->ansatte1_id;
            $user = User::findOne(['web_id' => $uId]);
            if (!$user){
                echo "No User With id: {$uId}\n";
                continue;
            }
            $prop->employee_id = $user->web_id;
            $prop->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190517_071225_UPDATE_property_employer_column cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190517_071225_UPDATE_property_employer_column cannot be reverted.\n";

        return false;
    }
    */
}
