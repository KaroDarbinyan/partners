<?php
namespace console\controllers;

use Yii;
use Exception;
use yii\console\Controller;


class CustomsController extends Controller
{
    private $id1 = 3000006;
    private $id2 = 3000026;
    private $tablesColumnMap = [
        "archive_form" => [
            'dep' => 'department_id',
            'user' => 'broker_id',
        ],
        "property_details" => [
            'dep' => 'avdeling_id',
            'user' => 'ansatte1_id',
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

    /**
     * change 06 department properties and archive forms to 26 department
     * Command: php yii customs/swap0626
     * @throws \yii\db\Exception
     */
    public function actionSwap0626()
    {
        foreach ($this->tablesColumnMap as $tableName => $columnNames) {
            if ($columnNames['dep']){
                Yii::$app->db->createCommand()->update($tableName, [$columnNames['dep'] => $this->id2], [$columnNames['dep'] => $this->id1])->execute();
            }

            if ($columnNames['user']) {
                foreach ($this->brokerMap as $oldId => $newId) {
                    try{
                        Yii::$app->db->createCommand()->update($tableName, [$columnNames['user'] => $newId], [$columnNames['user'] => $oldId])->execute();
                    }catch(Exception $e){
                        echo "Duplicate User {$newId}\n";
                    }
                }
            }
        }

    }
}