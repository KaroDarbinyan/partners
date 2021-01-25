<?php

use yii\db\Migration;

/**
 * Class m191004_094243_ALTER_FOREIGN_key_lead_log_to_forms
 */
class m191004_094243_ALTER_FOREIGN_key_lead_log_to_forms extends Migration
{
    private $parentTableName = "forms";
    private $childTableName = "lead_log";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $parentTable = $this->db->getTableSchema($this->parentTableName, true);
        $childTable = $this->db->getTableSchema($this->childTableName, true);
        if (!$parentTable || !$childTable) {
            echo "Table {$this->parentTableName} or {$this->childTableName} dose not exist \n";
            return;
        }
        try{
            $this->dropForeignKey('log_form',$this->childTableName);
            $this->addForeignKey(
                "log_form",
                $this->childTableName,
                'lead_id',
                $this->parentTableName,
                "id",
                'CASCADE'
            );
        }catch (Exception $e){}

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo 'm191004_094243_ALTER_FOREIGN_key_lead_log_to_forms migration cannot be revrted' . "\n";
    }


}
