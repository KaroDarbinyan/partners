<?php

use yii\db\Migration;
use console\controllers\WebmeglerController;
/**
 * Class m190708_060322_SLIP_HUGE_FILE
 */
class m190708_060322_SLIP_HUGE_FILE extends Migration
{
    private $file = 'webmegler-data/result-june.xml';
    private $itemsFolder = 'requestst-reults/items/';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $start = '';
        $item = '';
        $items = '';
        $line = '';
        $j = 0;
        $itemStart = '<eneiendom>';
        $itemStartLenght = 11;
        $itemEnd = '</eneiendom>';
        $itemEndtLenght = 12;
        $contentStart = '';
        $contentEnd = '</eiendommer>';
        $file = fopen($this->file, "r");
        /**
         * Move file pointer after xml start section
         */
        while (!feof($file) && strpos($line, $itemStart) === false) {
            $line = fgets($file);
            $contentStart .= $line ;
        }
        $line = substr($line, strpos($line, $itemStart));
        $contentStart = substr($contentStart, 0, strpos($contentStart, $itemStart));
        while(!feof($file)){
            $j++;
            $items = '';
            for ($i = 0; $i < 50; $i++){
                while (!feof($file)) {//Find property Start
                    $line = fgets($file);
                    if(strpos($line, $itemStart) !== false){
                        $item = substr($line, strpos($line, $itemStart));
                        break;
                    }
                }

                while (!feof($file)) {// Concant untill property end
                    $line = fgets($file);
                    if( strpos($line, $itemEnd) !== false ){
                        $item .= substr($line, 0, strpos($line, $contentEnd) + $itemEndtLenght + 1 );
                        break;
                    }
                    $item .= $line;
                }
                $items .= $item;
            }//End For
            $items = "{$contentStart}{$items}{$contentEnd}";
            $items = simplexml_load_string($items);
            $items = WebmeglerController::xmlObjToAssocArray($items);
            file_put_contents($this->itemsFolder . "item{$j}.json", json_encode($items));
        }
        $items = '';
        fclose($file);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_073820_UPDATE_database_from_huge_file cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_073820_UPDATE_database_from_huge_file cannot be reverted.\n";

        return false;
    }
    */
}
