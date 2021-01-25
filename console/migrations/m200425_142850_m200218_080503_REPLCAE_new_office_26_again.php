<?php

use yii\db\Migration;

/**
 * Class m200425_142850_m200218_080503_REPLCAE_new_office_26_again
 */
class m200425_142850_m200218_080503_REPLCAE_new_office_26_again extends Migration
{
    private $id1 = 3000006;
    private $id2 = 3000026;
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
        "3000363"=> '3000397',
        // "navn"=> "Alexander Vu Tran",
        "3000340"=> '3000393',
        // "navn"=> "Jannik Holm",
        "3000059"=> '3000392',
        // "navn"=> "Marius Wang",
        "3000060"=> '3000396',
        // "navn"=> "Milla Johnsen",
        "3000063"=> '3000394',
        // "navn"=> "Terje Rindal",
        "3000064"=> '3000395',
        // "navn"=> "Thor Wæraas",
    ];

    private $namesToChange = [
        ["id"=> "3000047",
            "navn"=> "Anne Pettersen (Regnskapsfører)",],
        ["id"=> "3000049",
            "navn"=> "Charlotte Davidsen",],
        ["id"=> "3000053",
            "navn"=> "Huong Pham",],
    ];


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
