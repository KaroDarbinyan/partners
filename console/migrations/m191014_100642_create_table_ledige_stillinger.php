<?php

use yii\db\Migration;

/**
 * Class m191014_100642_create_table_ledige_stillinger
 */
class m191014_100642_create_table_ledige_stillinger extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%ledige_stillinger}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'kontor' => $this->integer()->notNull()->unique(),
            'date' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m191014_100642_create_table_ledige_stillinger cannot be reverted.\n";

        return false;
    }

}
