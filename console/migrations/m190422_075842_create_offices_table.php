<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offices}}`.
 */
class m190422_075842_create_offices_table extends Migration
{
    private $tableName = '{{%offices}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offices}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("SET foreign_key_checks = 0;");
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}
