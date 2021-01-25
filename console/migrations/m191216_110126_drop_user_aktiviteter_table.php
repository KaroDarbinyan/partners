<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%user_aktiviteter}}`.
 */
class m191216_110126_drop_user_aktiviteter_table extends Migration
{
    private $tableName = '{{%user_aktiviteter}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // Create table if not exist
        if (!$this->db->getTableSchema($this->tableName, true) !== null) {
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
            ], $tableOptions);
        }
    }
}
