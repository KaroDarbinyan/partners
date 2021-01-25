<?php

use yii\db\Migration;

/**
 * Class m191225_060515_ADD_COLUMN_departments
 */
class m191225_060515_ADD_COLUMN_departments extends Migration
{
    private $tableName = "department";
    private function getColumns(){
        return [
            "acting"=> $this->integer(11)->notNull(),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
        }

        $update = Yii::$app->db->createCommand("UPDATE {$this->tableName} SET acting = avdelingsleder;");
        $update->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }
    }


}