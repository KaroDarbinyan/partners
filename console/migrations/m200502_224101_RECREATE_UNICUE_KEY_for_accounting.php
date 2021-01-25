<?php

use yii\db\Migration;

/**
 * Class m200502_224101_RECREATE_UNICUE_KEY_for_accounting
 */
class m200502_224101_RECREATE_UNICUE_KEY_for_accounting extends Migration
{
    private $tableName = '{{%accounting}}';
    private $indexName = 'webmegler_unicue_id';
    private $columns = ['bilagsnummer','linjenummer','db_id', 'oppdragsnummer'];

    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        try{
            $this->dropIndex($this->indexName, $this->tableName);
        }catch(Exception $e){
            echo "<pre>";
            echo $e->getMessage();
            echo "</pre>";
        }
        $this->createIndex($this->indexName, $this->tableName, $this->columns,true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        $this->dropIndex($this->indexName, $this->tableName);
    }
}
