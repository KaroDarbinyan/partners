<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forms}}`.
 */
class m190404_092657_create_forms_table extends Migration
{
    private $tableName = '{{%forms}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable( $this->tableName, [
            'id' => $this->primaryKey(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'post_number' => $this->integer(11)->notNull(),
            'phone' => $this->integer(11)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'message' => $this->text(),
            'subscribe_email' => $this->boolean()->notNull()->defaultValue(false),
            'type'=> $this->string(255)->notNull(),
            'date_create'=> $this->dateTime()->notNull(),
            'date_update'=> $this->dateTime()->notNull(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}
