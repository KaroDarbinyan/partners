<?php

use common\models\PropertyVisits;
use common\models\UserAktiviteter;
use yii\db\ActiveQuery;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_aktiviteter}}`.
 */
class m190904_140433_create_user_aktiviteter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_aktiviteter}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'year' => $this->string(4),
            'month' => $this->string(4),
            'data' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_aktiviteter}}');
    }
}
