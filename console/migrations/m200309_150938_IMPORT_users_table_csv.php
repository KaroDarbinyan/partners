<?php

use yii\db\Migration;

/**
 * Class m200309_150938_IMPORT_users_table_csv
 */
class m200309_150938_IMPORT_users_table_csv extends Migration
{
    private $tableName = 'user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $users = $fields = array(); $i = 0;
        $handle = @fopen(__DIR__ . DIRECTORY_SEPARATOR . "sqls" . DIRECTORY_SEPARATOR . "2_user.csv", "r");
        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($fields)) {// keys
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k=>$value) {
                    if (in_array($fields[$k],['firma_id'])){continue;}
                    //web_id,dagligleder,avdelingsleder,fagansvarlig,besokadresse,email,telefon,short_name
                    $users[$i][$fields[$k]] = $value;
                }
                $users[$i]['url'] = "broker_{$users[$i]['web_id']}";

                $this->update($this->tableName, $users[$i], ['web_id'=> $users[$i]['web_id']]);
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
        echo "m200309_150938_IMPORT_users_table_csv cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200309_150938_IMPORT_users_table_csv cannot be reverted.\n";

        return false;
    }
    */
}
