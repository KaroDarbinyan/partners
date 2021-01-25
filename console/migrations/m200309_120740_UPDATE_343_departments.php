<?php

use yii\db\Migration;

/**
 * Class m200309_120740_UPDATE_343_departments
 */
class m200309_120740_UPDATE_343_departments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $deps = $fields = array(); $i = 0;
        $handle = @fopen(__DIR__ . DIRECTORY_SEPARATOR . "sqls" . DIRECTORY_SEPARATOR . "2_dep.csv", "r");
        if ($handle) {
            while (($row = fgetcsv($handle, 4096)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k=>$value) {
                    //web_id,dagligleder,avdelingsleder,fagansvarlig,besokadresse,email,telefon,short_name
                    $deps[$i][$fields[$k]] = $value;
                }
                $deps[$i]['url'] = "office_{$deps[$i]['web_id']}";
                $this->update(\common\models\Department::tableName(), $deps[$i], ['web_id'=> $deps[$i]['web_id']]);
                $i++;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200305_171253_UPDATE_departments_and_brokers cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200305_171253_UPDATE_departments_and_brokers cannot be reverted.\n";

        return false;
    }
    */
}
