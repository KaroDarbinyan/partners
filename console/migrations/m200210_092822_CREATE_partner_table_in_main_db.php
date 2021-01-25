<?php

use yii\db\Migration;

/**
 * Class m200210_092822_CREATE_partner_table_in_main_db
 */
class m200210_092822_CREATE_partner_table_in_main_db extends Migration
{
    private $tableName = '{{%partner}}';

    public function init()
    {
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp(){
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $options = [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'slug' => $this->string()->unique(),
        ];
        $this->createTable($this->tableName, $options, $tableOptions);
        $c = $this->db->multyConnections;
        unset($c['main']);
        $slugs = array_keys($c);

        $rows = [];
        foreach ($slugs as $slug) {
            $rows[] = [
                'name'=>ucwords(str_replace('_', ' ', $slug)),
                'slug'=>$slug
            ];
        }
        $this->db->createCommand()->batchInsert(
            $this->tableName,
            ['name','slug'],
            $rows
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema( $this->tableName, true ) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}