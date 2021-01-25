<?php

use yii\db\Migration;

/**
 * Class m200225_143156_REMOVE_usless_departments_and_users
 */
class m200225_143156_REMOVE_usless_departments_and_users extends Migration
{
    private $tableName = 'user';
    private $table2Name = 'department';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $table = $this->db->getTableSchema($this->table2Name, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $time = $this->beginCommand("delete from {$this->tableName} AND {$this->table2Name}");
        $this->db->createCommand(
            "DELETE u, d FROM {$this->tableName} as u LEFT JOIN {$this->table2Name} as d  ON u.id_avdelinger = d.web_id WHERE d.partner_id IS NULL"
        )->execute();
        $this->endCommand($time);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200225_143156_REMOVE_usless_departments_and_users cannot be reverted.\n";
    }

}
