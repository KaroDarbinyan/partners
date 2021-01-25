<?php

use yii\db\Migration;

/**
 * Class m200502_132605_ADD_UNICUE_KEY_to_accounting
 */
class m200502_132605_ADD_UNICUE_KEY_to_accounting extends Migration
{
    private $tableName = '{{%accounting}}';
    private $indexName = 'webmegler_unicue_id';
    private $columns = ['bilagsnummer','linjenummer'];

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp(){
        $this->createIndex($this->indexName, $this->tableName, $this->columns,true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        $this->dropIndex($this->indexName, $this->tableName);
    }
}
