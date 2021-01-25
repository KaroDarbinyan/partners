<?php

use yii\base\Security;
use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190731_091814_UPDATE_USERS_passwords_logins
 */
class m190731_091814_UPDATE_USERS_passwords_logins extends Migration
{
    private $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190731_091814_UPDATE_USERS_passwords_logins cannot be reverted.\n";
    }

    private function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}
