<?php

use yii\db\Migration;

/**
 * Class m190325_130609_create_user
 */
class m190325_130609_create_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user',[
            'username'=>'Admin',
            'auth_key'=>'NLJPOXnoyyDGwa-Lo3usOgOb-IoHyCZK',
            'password_hash'=>'$2y$13$/9I9i5NQ9Bcw9qBsvhIAb.N56oMCSRS1kwi9M6u3m.vKR3cRu0J/2',
            'password_reset_token'=>NULL,
            'email'=> 'admin@admin.ru',
            'status'=>10,
            'created_at'=>1551385378,
            'updated_at'=>1551385378
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190325_130609_create_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190325_130609_create_user cannot be reverted.\n";

        return false;
    }
    */
}
