<?php

use common\models\Department;
use common\models\News;
use console\components\MultyConnection;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%department_to_news}}`.
 */
class m200318_093838_create_department_to_news_table extends Migration
{

    private $tableName = '{{%department_to_news}}';


    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $db = Yii::$app->db;
        /** @var MultyConnection $db */
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if($tableSchema){
            echo 'table already exist';return;// table already exist
        }
        $news_ids = News::find()->select(["id"])->column();
        $dep_ids = Department::find()->select(["web_id"])->column();
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'department_web_id' => $this->string()->notNull(),
            'news_id' => $this->string()->notNull()
        ]);
        foreach ($news_ids as $news_id){
            $rows = [];
            foreach ($dep_ids as $dep_id){
               $rows[] = ["department_web_id" => $dep_id, "news_id" => $news_id];
            }
            $db->createCommand()->batchInsert($this->tableName,[
                "department_web_id", "news_id"
            ], $rows)->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $db = Yii::$app->db;
        /** @var MultyConnection $db */
        foreach (array_keys($db->multyConnections) as $k) {
            $db->setActiveConnection($k);
            if(!$this->db->getTableSchema($this->tableName, true)){
                continue;// table not exist
            }
            $this->dropTable($this->tableName);
        }
        $db->setActiveConnection('main');
    }
}
