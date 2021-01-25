<?php

use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m190923_111811_events_table
 */
class m190923_111811_calendar_events_table extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%calendar_events}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'classes' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        echo "m190923_111811_events_table cannot be reverted.\n";

        return false;
    }

}
