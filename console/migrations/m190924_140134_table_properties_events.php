<?php

use common\models\CalendarEvent;
use common\models\PropertyDetails;
use yii\db\Migration;

/**
 * Class m190924_140134_table_properties_events
 */
class m190924_140134_table_properties_events extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%properties_events}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer(),
            'event_id' => $this->integer(),
            'start_time' => $this->string(),
            'end_time' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('properties_events', '{{%properties_events}}', 'property_id', PropertyDetails::tableName(), 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('_events', '{{%properties_events}}', 'event_id', CalendarEvent::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m190924_140134_table_properties_events cannot be reverted.\n";

        return false;
    }
}
