<?php

use yii\db\Migration;

/**
 * Class m190410_123052_CONTACTS_save_in_file
 */
class m190410_123052_CONTACTS_save_in_file extends Migration
{

    private $fileName = 'frontend/web/requests/contacts_all.json';

    /**
     * {@inheritdoc}
     */
    public function safeUp(){
//        $deps = Yii::$app->WebmeglerApiHelper->get('contacts', [false,], false);
//        file_put_contents($this->fileName, json_encode($deps));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190410_090223_GET_all_employees_into_file do nothing. \n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190410_090223_GET_all_employees_into_file cannot be reverted.\n";

        return false;
    }
    */
}
