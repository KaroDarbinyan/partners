<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%signatur}}`.
 */
class m200328_123454_create_signatur_table extends Migration
{

    private $tableName = '{{%signatur}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if ($tableSchema) {
            echo 'table already exist';
            return;// table already exist
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'left_content' => $this->string(),
            'right_content' => $this->string(),
            'user_id' => $this->string()->notNull()->unique()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if(!$tableSchema){
            echo 'table not exist';return;// table not exist
        }
        $this->dropTable($this->tableName);

    }
}
