<?php

use yii\db\Migration;

/**
 * Class m200309_091358_IMPORT_343_data_departments_partners_users
 */
class m200309_091358_IMPORT_343_data_departments_partners_users extends Migration
{
    private $tableName = 'user';
    private $tableName2 = 'department';

    /**
     * {@inheritdoc}
     * @throws \Matrix\Exception
     * @throws \yii\base\Exception
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName2, true);
        if (!$table) {
            echo "Table {$this->tableName2} dose not exist \n";
            return;
        }
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }

        $api = Yii::$app->WebmeglerApiHelper;
        /** @var \common\components\WebmeglerApiHelper $api */
        $api->companyWebId = 343;
        $u = new \common\models\User();
        $d = new \common\models\Department();
        /** @var \common\components\WebmeglerApiHelper $api */
        $deps = $api->get('department')['avdeling'];
        $passMap = [];
        foreach ($deps as $dep) {
            /*
             * Departments
             */
                $brokers = $api->get('employees',[$dep['id']]);
                if(!isset($brokers['ansatt'])){
                    echo "<pre>";
                    var_dump($brokers);
                    echo "</pre>";
                    echo "department without brokers\n";
                    continue;
                }
                $dep['web_id'] = $dep['id'];
                $dep['url'] = strtolower(str_replace(' ', '_', $dep['navn'])) . '_' . $dep['web_id'];
                $dep['short_name'] = $dep['navn'];
                $dep['partner_id'] = 1;
                unset($dep['id']);

                $r = [];
                foreach ($d->attributes() as $attribute) {
                    if (!isset($dep[$attribute])){continue;}
                    $r[$attribute] = $dep[$attribute];
                }
                $this->upsert($this->tableName2,$r);

            /*
             * Brokers
             */
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
                    'dep_id' => $dep['web_id'],
                    'dep_name' => $dep['navn'],
                ];
                $r = [];

                foreach ($u->attributes() as $attribute) {
                    if (!isset($broker[$attribute])){continue;}
                    $r[$attribute] = $broker[$attribute];
                }
                $this->upsert($this->tableName,$r);


            }
        }

        // Open a file in write mode ('w')
        $fp = fopen('users_343.csv', 'w');
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
