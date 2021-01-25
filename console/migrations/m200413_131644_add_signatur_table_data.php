<?php

use common\models\Signatur;
use common\models\User;
use yii\db\Migration;

/**
 * Class m200413_131644_add_signatur_table_data
 */
class m200413_131644_add_signatur_table_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $users = User::find()->joinWith(["department"])->all();

        foreach ($users as $user) {
            $signatur = Signatur::findOne(["user_id" => $user->id]) ?? new Signatur();

            if (!$signatur->left_content) {
                $signatur->left_content = implode("", [
                    $user->short_name ? $user->short_name : "",
                    $user->tittel ? "\r\n{$user->tittel}" : "",
                    $user->mobiltelefon ? "\r\n\r\nTelefon: {$user->mobiltelefon}" : "",
                    $user->department->telefon ? "\r\nKontor: {$user->department->telefon}" : "",
                    $user->department->telefax ? "\r\nFaks: {$user->department->telefax}" : "",
                ]);
            }

            if (!$signatur->right_content) {
                $signatur->right_content = implode("", [
                    "Besøksadresse:",
                    "\r\n\r\n{$user->department->poststed}: {$user->department->besoksadresse}",
                ]);
            }

            $signatur->user_id = $user->id;
            $signatur->save();
        }


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
        echo "m200413_131644_add_signatur_table_data cannot be reverted.\n";

        return false;
    }
    */
}
