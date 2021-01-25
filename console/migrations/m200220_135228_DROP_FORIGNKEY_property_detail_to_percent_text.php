<?php

use yii\db\Migration;

/**
 * Class m200220_135228_DROP_FORIGNKEY_property_detail_to_percent_text
 */
class m200220_135228_DROP_FORIGNKEY_property_detail_to_percent_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $db = Yii::$app->db;
        /** @var \console\components\MultyConnection $db */
        foreach (array_keys($db->multyConnections) as $k) {
            $db->setActiveConnection($k);
            try{
                $this->dropForeignKey('property_detail_to_percent_text','{{%percent_text}}');
            }catch(Exception $e){
                echo "property_detail_to_percent_text foreignKey dose not exist\n";
            }
        }
        $db->setActiveConnection('main');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_135228_DROP_FORIGNKEY_property_detail_to_percent_text cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_135228_DROP_FORIGNKEY_property_detail_to_percent_text cannot be reverted.\n";

        return false;
    }
    */
}
