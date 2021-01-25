<?php

use common\models\Department;
use common\models\News;
use common\models\Partner;
use yii\db\Migration;

/**
 * Class m200411_090142_rename_partner_to_news_to_department_to_news
 */
class m200411_090142_rename_partner_to_news_to_department_to_news extends Migration
{

    private $oldTableName = '{{%partner_to_news}}';
    private $newTableName = '{{%department_to_news}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $newTableSchema = $this->db->getTableSchema($this->newTableName, true);
        if ($newTableSchema) $this->dropTable($this->newTableName);

        $oldTableSchema = $this->db->getTableSchema($this->oldTableName, true);
        if ($oldTableSchema) $this->dropTable($this->oldTableName);

        $this->createTable($this->newTableName, [
            'id' => $this->primaryKey(),
            'news_id' => $this->string()->notNull(),
            'partner_id' => $this->string()->notNull(),
            'department_web_id' => $this->string()->notNull()
        ]);

        $news_ids = News::find()->select(["id"])->column();
        $departments = Department::find()->all();

        foreach ($news_ids as $news_id) {
            $rows = [];
            foreach ($departments as $department) {
                $rows[] = [
                    "news_id" => $news_id,
                    "partner_id" => $department->partner_id,
                    "department_web_id" => $department->web_id,
                ];
            }
            $this->db->createCommand()->batchInsert($this->newTableName, [
                "news_id", "partner_id", "department_web_id"
            ], $rows)->execute();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $newTableSchema = $this->db->getTableSchema($this->newTableName, true);
        if ($newTableSchema) $this->dropTable($this->newTableName);

        $oldTableSchema = $this->db->getTableSchema($this->oldTableName, true);
        if ($oldTableSchema) $this->dropTable($this->oldTableName);

        $this->createTable($this->oldTableName, [
            'id' => $this->primaryKey(),
            'news_id' => $this->string()->notNull(),
            'partner_id' => $this->string()->notNull(),
            'department_web_id' => $this->string()->notNull(),
        ]);

        $news_ids = News::find()->select(["id"])->column();
        $departments = Department::find()->all();

        foreach ($news_ids as $news_id) {
            $rows = [];
            foreach ($departments as $department) {
                $rows[] = ["news_id" => $news_id, "partner_id" => $department->partner_id, "department_web_id" => $department->web_id];
            }
            $this->db->createCommand()->batchInsert($this->oldTableName, [
                "news_id", "partner_id", "department_web_id"
            ], $rows)->execute();
        }

    }
}
