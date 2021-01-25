<?php

use common\models\Department;
use common\models\DepartmentToNews;
use common\models\News;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department_to_news}}`.
 */
class m200415_160330_add_roles_column_to_department_to_news_table extends Migration
{

    private $tableName = '{{%department_to_news}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName);
        if ($tableSchema) {
            if (!isset($tableSchema->columns["roles"])) {
                $this->addColumn($this->tableName, "roles", $this->string());

                DepartmentToNews::deleteAll();
                News::updateAll(["user_role" => "partner-director-broker"]);
                $news_ids = News::find()->select(["id"])->column();
                $departments = Department::find()->all();

                foreach ($news_ids as $news_id) {
                    $rows = [];
                    foreach ($departments as $department) {
                        $rows[] = [
                            "news_id" => $news_id,
                            "partner_id" => $department->partner_id,
                            "department_web_id" => $department->web_id,
                            "roles" => "partner-director-broker"
                        ];
                    }
                    $this->db->createCommand()->batchInsert($this->tableName, [
                        "news_id", "partner_id", "department_web_id", "roles"
                    ], $rows)->execute();
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName);
        if ($tableSchema) {
            if (isset($tableSchema->columns["roles"])) {
                $this->dropColumn($this->tableName, "roles");
            }
        }
    }
}
