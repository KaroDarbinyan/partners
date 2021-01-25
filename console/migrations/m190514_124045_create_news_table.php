<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m190514_124045_create_news_table extends Migration
{

    private $tableName = '{{%news}}';
    private $userTable = '{{%user}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->userTable, true) !== null) {
            $this->addColumn($this->userTable, 'role', $this->string());
            $this->update($this->userTable, ['role' => 'admin',],['id'=>86]);

        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'text' => $this->text(),
            'image_name' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
        $this->dropColumn($this->userTable, 'role');
    }
}
