<?php

use yii\db\Migration;

/**
 * Class m200304_045536_ADD_leader_column_to_partner
 */
class m200304_045536_ADD_leader_column_to_partner extends Migration
{
    private $tableName = 'partner';
    private function getColumns(){
        return [
            "leader_id"=> $this->integer(11)->defaultValue(3000216),
        ];
    }
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp(){
        if (!$this->db->getTableSchema($this->tableName, true) ) {
            echo "Table {$this->tableName} Doesn't exist \n";
            return false;
        }
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }
    }
}
