<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tv_ads}}`.
 */
class m200514_214631_create_vindulosning_table extends Migration
{

    private $tableName = '{{%vindulosning}}';
    private $removeTableName = '{{%partner_settings}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->removeTableName, true) !== null) {
            $this->dropTable($this->removeTableName);
        }

        $fields = [
            'id' => $this->primaryKey(),
            'view' => $this->string(),
            'property_ids' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'column' => $this->integer()->notNull(),
            'active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ];

        $this->createTable($this->tableName, $fields, $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}
