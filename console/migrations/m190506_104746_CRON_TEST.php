<?php

use yii\db\Migration;

/**
 * Class m190506_104746_CRON_TEST
 */
class m190506_104746_CRON_TEST extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        file_put_contents('cron_test.txt', time() . "\n", FILE_APPEND);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190506_104746_CRON_TEST cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_104746_CRON_TEST cannot be reverted.\n";

        return false;
    }
    */
}
