<?php

use yii\db\Migration;

/**
 * Class m200221_091513_IMPORT_users_to_databases
 */
class m200221_091513_IMPORT_users_to_databases extends Migration
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

        $api = Yii::$app->WebmeglerApiHelper;
        $b = new \common\models\User();
        /** @var \common\components\WebmeglerApiHelper $api */
        $deps = $api->get('department')['avdeling'];
        $passMap = [];
        foreach ($deps as $dep) {
            $brokers = $api->get('employees',[$dep['id']]);
            if(!isset($brokers['ansatt'])){
                echo "<pre>";
                var_dump($brokers);
                echo "</pre>";
                echo "department without brokers\n";
                continue;
            }
            $brokers = $brokers['ansatt'];
            foreach ($brokers as $broker) {
                $broker['web_id'] = $broker['id'];
                $broker['role'] = $broker['web_id'] == $dep['avdelingsleder'] ? 'director' : 'broker';
                $broker['url'] = strtolower(str_replace(' ', '_', $broker['navn'])) . '_' . $broker['web_id'];
                $p = Yii::$app->getSecurity()->generateRandomString(6);
                $broker['password_hash'] = Yii::$app->getSecurity()->generatePasswordHash($p);;
                $broker['updated_at'] =
                $broker['created_at'] = time();
                $broker['short_name'] = $broker['navn'];
                unset($broker['id']);

                $broker['username'] = $broker['web_id'];
                $passMap[$broker['username']] = [
                    'id' => $broker['web_id'],
                    'name' => $broker['navn'],
                    'login' => $broker['username'],
                    'pass' => $p,
                    'dep_id' => $dep['id'],
                    'dep_name' => $dep['navn'],
                ];
                $r = [];
                foreach ($b->attributes() as $attribute) {
                    if (!isset($broker[$attribute])){continue;}
                    $r[$attribute] = $broker[$attribute];
                }
                $this->insert($this->tableName,$r);
            }
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
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $this->truncateTable($this->tableName);
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
