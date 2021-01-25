<?php

use common\models\News;
use yii\db\Migration;

/**
 * Class m200918_073107_update_news_user_role_data
 */
class m200918_073107_update_news_user_role_data extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->updateNews("up");
    }

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeDown()
    {
        $this->updateNews("down");
    }


    /**
     * @param $migrate_type
     * @throws \yii\db\Exception
     */
    public function updateNews($migrate_type)
    {
        $all_news = News::find()->all();
        $db = Yii::$app->db;
        $rows = [];

        if ($migrate_type === 'up') {
            foreach ($all_news as $news) {
                $rows[] = [
                    'id' => $news['id'],
                    'user_role' => $news['user_role'] ? "superadmin-{$news['user_role']}" : "superadmin"
                ];
            }
        } else {
            foreach ($all_news as $news) {
                $rows[] = [
                    'id' => $news['id'],
                    'user_role' => $news['user_role'] === "superadmin" ? null :
                        str_replace(["-superadmin", "superadmin-", "superadmin"], ["", "", ""], $news['user_role'])
                ];
            }
        }


        $sql = $db->queryBuilder->batchInsert(
            '{{%news}}',
            ['id', 'user_role'],
            $rows
        );
        $db->createCommand("{$sql} ON DUPLICATE KEY UPDATE id = VALUES(id), user_role = VALUES(user_role)")->execute();

    }

}
