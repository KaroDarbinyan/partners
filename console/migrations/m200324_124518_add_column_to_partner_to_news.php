<?php

use common\models\Department;
use common\models\News;
use yii\db\Migration;

/**
 * Class m200324_124518_add_column_to_partner_to_news
 */
class m200324_124518_add_column_to_partner_to_news extends Migration
{

    private $tableName = '{{%partner_to_news}}';
    private $column = 'department_web_id';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if (!$tableSchema) {
            echo $this->tableName . ' table not exist';
            return;
        }

        if (!isset($tableSchema->columns[$this->column])) {

            $this->addColumn($this->tableName, $this->column, $this->string()->notNull());
            $this->db->createCommand()->truncateTable($this->tableName)->execute();
            $news_ids = News::find()->select(["id"])->column();
            $deps = Department::find()->select(["web_id", "partner_id"])->all();

            foreach ($news_ids as $news_id) {
                $rows = [];
                foreach ($deps as $dep) {
                    $rows[] = [
                        $this->column => $dep->web_id,
                        "partner_id" => $dep->partner_id,
                        "news_id" => $news_id
                    ];
                }
                $this->db->createCommand()->batchInsert($this->tableName, [
                    $this->column, "partner_id", "news_id"
                ], $rows)->execute();
            }
            return;
        }
        echo $this->column . ' column already exist';
        return;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if (!$tableSchema) {
            echo $this->tableName . ' table not exist';
            return;
        }

        if (!isset($tableSchema->columns[$this->column])) {
            echo $this->column . ' column not exist';
            return;
        }

        $this->dropColumn($this->tableName, $this->column);

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200324_124518_add_column_to_partner_to_news cannot be reverted.\n";

        return false;
    }
    */
}
