<?php
namespace console\controllers\UpdateTraits;

use common\models\Accounting;
use common\models\AllPostNumber;
use common\models\PropertyDetails;
use Matrix\Exception;
use Yii;
use yii\db\ActiveRecord;

trait UpdateAccountingTrait{
    /**
     *
     * @param $jsonAcc
     * @param $c
     * @param bool $isShort
     * @return Accounting
     */
    private static function getAccountingModel($jsonAcc, $c, $isShort = false){
        $newAcc = new Accounting();
        $attrs = $newAcc->attributes();

        $defaultsMap = [];// fields that must be saved as default value if they are missing in json

        $timeMap = [// Fields that must be converted to seconds from string date
            'bilagsdato',
            'endretdato',
        ];

        $intMap = [];// Fields that must be converted to int

        foreach ($attrs as $attrName) {
            $jsonKey = str_replace('__', '-', $attrName);
            if (!isset($jsonAcc[$jsonKey])) {
                if (isset($defaultsMap[$jsonKey])) {// get attr from defaults if missing in webmegler data
                    $column = $defaultsMap[$jsonKey];
                } else {continue;}// Skip if attribute is missing in webmegler data and in defaults list
            } else {$column = $jsonAcc[$jsonKey];}

            if (is_array($column)) {continue;}// Ignore nested params
            if (in_array($attrName, $timeMap)) {$column = strtotime($column);}// Convert dates to seconds
            if (in_array($attrName, $intMap)) {$column = intval($column);}// remove spaces
            $newAcc->setAttribute($attrName, $column);
        }
        return $newAcc;
    }

    /**
     * @param Accounting[] $items
     * @param ActiveRecord $demoObj
     * @throws \yii\db\Exception
     */
    private function batchUpdateAccounting($items, $demoObj){
        $rows = [];
        $log = [];
        if (!$items){return;}

        foreach ($items as $item) {
            $item->db_id = $this->companyWebId;
            $rows[] = $item->attributes;
            // Uncomment for test log in base
            // $log[] = [
            //     'key' => '0' ,
            //     'b' => $item->bilagsnummer ,
            //     'o' => $item->oppdragsnummer,
            //     'l' => $item->linjenummer,
            //     'd' => $this->companyWebId,
            //     'message' => json_encode($item->attributes),
            // ];

        }

        // try{
        //     Yii::$app->db->createCommand()->batchInsert('log_test', array_keys($log[0]), $log)->execute();
        // }catch(Exception $e){}

        $inserCommand = Yii::$app->db->createCommand()->batchInsert(Accounting::tableName(), $demoObj->attributes(), $rows);
        // TODO: implement replace by yii support whet yii add functional for it
        $inserCommand = str_replace("INSERT INTO ","REPLACE INTO ",$inserCommand->getRawSql());
        Yii::$app->db->createCommand($inserCommand)->execute();
    }
}

