<?php

use common\models\Department;
use common\models\News;
use common\models\Partner;
use yii\db\Migration;

/**
 * Class m200323_164636_rename_department_to_news_to_partner_to_news
 */
class m200323_164636_rename_department_to_news_to_partner_to_news extends Migration
{

    private $oldTableName = '{{%department_to_news}}';
    private $newTableName = '{{%partner_to_news}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $newTableSchema = $this->db->getTableSchema($this->newTableName, true);
        if ($newTableSchema) {
            echo $this->newTableName . ' table already exist';
            return;// table already exist
        }

        $oldTableSchema = $this->db->getTableSchema($this->oldTableName, true);
        if ($oldTableSchema) {
            $this->renameTable($this->oldTableName, $this->newTableName);
            $this->renameColumn($this->newTableName, "department_web_id", "partner_id");
            $this->db->createCommand()->truncateTable($this->newTableName)->execute();
            $news_ids = News::find()->select(["id"])->column();
            $prt_ids = Partner::find()->select(["id"])->column();

            foreach ($news_ids as $news_id) {
                $rows = [];
                foreach ($prt_ids as $prt_id) {
                    $rows[] = ["partner_id" => $prt_id, "news_id" => $news_id];
                }
                $this->db->createCommand()->batchInsert($this->newTableName, [
                    "partner_id", "news_id"
                ], $rows)->execute();
            }
            return;
        }
        echo $this->oldTableName . ' table not exist';
        return;// table already exist

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $newTableSchema = $this->db->getTableSchema($this->newTableName, true); //partner_to_news
        if ($newTableSchema) {
            $this->renameTable($this->newTableName, $this->oldTableName);
            $this->renameColumn($this->oldTableName, "partner_id", "department_web_id");
            return;
        }

        $oldTableSchema = $this->db->getTableSchema($this->oldTableName, true);  //department_to_news
        if (!$oldTableSchema) {
            $news_ids = News::find()->select(["id"])->column();
            $dep_ids = Department::find()->select(["web_id"])->column();
            $this->createTable($this->oldTableName, [
                'id' => $this->primaryKey(),
                'department_web_id' => $this->string()->notNull(),
                'news_id' => $this->string()->notNull()
            ]);
            foreach ($news_ids as $news_id) {
                $rows = [];
                foreach ($dep_ids as $dep_id) {
                    $rows[] = ["department_web_id" => $dep_id, "news_id" => $news_id];
                }
                $this->db->createCommand()->batchInsert($this->oldTableName, [
                    "department_web_id", "news_id"
                ], $rows)->execute();
            }
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200323_164636_rename_department_to_news_to_partner_to_news cannot be reverted.\n";

        return false;
    }
    */
}
