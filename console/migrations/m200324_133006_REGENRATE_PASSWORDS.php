<?php

use yii\db\Migration;

/**
 * Class m200324_133006_REGENRATE_PASSWORDS
 */
class m200324_133006_REGENRATE_PASSWORDS extends Migration
{
    private $tableName = 'user';

    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     * @throws Throwable
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }

        $brokers = \common\models\User::find()->joinWith(['department'])->all();
        /** @var \common\models\User[] $brokers */
        foreach ($brokers as $broker) {
            $p = Yii::$app->getSecurity()->generateRandomString(6);
            $broker->password_hash = Yii::$app->getSecurity()->generatePasswordHash($p);
            if (!$broker->department){
                $this->delete($this->tableName,['web_id' => $broker->web_id]);
                continue;
            }
            $passMap[$broker['username']] = [
                'id' => $broker->web_id,
                'name' => $broker->navn,
                'login' => $broker->username,
                'pass' => $p,
                'dep_id' => $broker->department->web_id,
                'dep_name' => $broker->department->navn,
            ];
            $r = [];
            foreach ($broker->attributes() as $attribute) {
                $r[$attribute] = $broker[$attribute];
            }
            $this->update($this->tableName,$r,['web_id'=>$broker->web_id]);
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
    public function safeDown(){
        echo "m200221_091513_IMPORT_users_to_databases cannot be reverted.\n";
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