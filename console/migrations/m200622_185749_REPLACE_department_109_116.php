<?php

use yii\db\Migration;

/**
 * Class m200622_185749_REPLACE_department_109_116
 */
class m200622_185749_REPLACE_department_109_116 extends Migration
{
    private $id1 = 3000109;
    private $id2 = 3000116;
    private $tablesColumnMap = [
        "department" => [
            'dep' => 'web_id',
            'user' => 'avdelingsleder',
        ],
        "archive_form" => [
            'dep' => 'department_id',
            'user' => 'broker_id',
        ],
        "budsjett" => [
            'dep' => 'avdeling_id',
            'user' => 'user_id',
        ],
        "forms" => [
            'dep' => 'department_id',
            'user' => 'broker_id',
        ],
        "lead_log" => [
            'dep' => false,
            'user' => 'user_id',
        ],
        "post_number" => [
            'dep' => 'department_id',
            'user' => false,
        ],
        "property_details" => [
            'dep' => 'avdeling_id',
            'user' => 'ansatte1_id',
        ],
        "user" => [
            'dep' => 'department_id',
            'user' => 'web_id',
        ],
    ];

    private $brokerMap = [
        "3001685"=>	"3001732",
        "3001611"=>	"3001730",
        "3001612"=>	"3001729",
    ];

    private $namesToChange = [];


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->tablesColumnMap as $tableName => $columnNames) {
            $table = $this->db->getTableSchema($tableName, true);
            if (!$table) {
                echo "Table {$tableName} dose not exist \n";
                continue;
            }
            if ($columnNames['dep']){
                $this->update($tableName, [$columnNames['dep'] => $this->id2], [$columnNames['dep'] => $this->id1]);
            }

            if ($columnNames['user']) {
                foreach ($this->brokerMap as $oldId => $newId) {
                    try{
                        $this->update($tableName, [$columnNames['user'] => $newId], [$columnNames['user'] => $oldId]);
                    }catch(Exception $e){
                        echo "Duplicate User {$newId}\n";
                    }
                }
            }
        }

        // Add dot to inajktiv users names at the end
        foreach ($this->namesToChange as $broker) {
            $this->update('user', ['navn' => $broker['navn'] . '.'], ['web_id' => $broker['id']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->tablesColumnMap as $tableName => $columnNames) {
            $table = $this->db->getTableSchema($tableName, true);
            if (!$table) {
                echo "Table {$tableName} dose not exist \n";
                continue;
            }
            if ($columnNames['dep']){
                $this->update($tableName, [$columnNames['dep'] => $this->id1], [$columnNames['dep'] => $this->id2]);
            }
            if ($columnNames['user']) {
                foreach ($this->brokerMap as $oldId => $newId) {
                    $this->update($tableName, [$columnNames['user'] => $oldId], [$columnNames['user'] => $newId]);
                }
            }
        }

        // Add dot to inajktiv users names at the end
        foreach ($this->namesToChange as $broker) {
            $this->update('user', ['navn' => $broker['navn'], ], [ 'web_id' => $broker['id'] ]);
        }
    }
}