<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%budsjett}}`.
 */
class m190705_073938_create_budsjett_table extends Migration
{

    private $tableName = '{{%budsjett}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'inntekt' => $this->integer(),
            'snittprovisjon' => $this->integer(),
            'hitrate' => $this->integer(),
            'befaringer' => $this->integer(),
            'salg' => $this->integer(),
            'year' => $this->integer(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%budsjett}}');
    }
}
