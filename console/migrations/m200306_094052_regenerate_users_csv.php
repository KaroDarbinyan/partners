<?php

use yii\db\Migration;

/**
 * Class m200306_094052_regenerate_users_csv
 */
class m200306_094052_regenerate_users_csv extends Migration
{
    private $tableName = 'user';

    /**
     * {@inheritdoc}
     * @throws \Matrix\Exception
     * @throws \yii\base\Exception
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $passMap = [];
        $brokers = \common\models\User::find()->asArray()->where(['inaktiv_status' => -1])->all();
        foreach ($brokers as $broker) {
            $p = Yii::$app->getSecurity()->generateRandomString(6);
            $broker['password_hash'] = Yii::$app->getSecurity()->generatePasswordHash($p);
            $broker['updated_at'] = time();
            $passMap[$broker['username']] = [
                'id' => $broker['web_id'],
                'name' => $broker['navn'],
                'login' => $broker['username'],
                'pass' => $p,
                'dep_id' => $broker['id_avdelinger'],
            ];
            $r = [];
            $this->update($this->tableName,$broker,['web_id'=>$broker['web_id']]);
        }

        // Open a file in write mode ('w')
        $fp = fopen('users.csv', 'w');
        fputcsv($fp, array_keys(current($passMap)));

        // Loop through file pointer and a line 872
        foreach ($passMap as $u) {
            fputcsv($fp, $u);
        }

        fclose($fp);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200306_094052_regenerate_users_csv cannot be reverted.\n";

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200221_091513_IMPORT_users_to_databases cannot be reverted.\n";

        return false;
    }
    */
}