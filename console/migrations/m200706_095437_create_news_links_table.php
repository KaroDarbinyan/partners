<?php

use common\models\News;
use yii\db\Migration;
use yii\helpers\FileHelper;

/**
 * Handles the creation of table `{{%news_links}}`.
 */
class m200706_095437_create_news_links_table extends Migration
{
    private $tableName = '{{%news_links}}';

    private function removeColumns()
    {
        return [
            "image_name" => $this->string(),
        ];
    }

    private function getColumns()
    {
        return [
            "id" => $this->primaryKey(),
            "news_id" => $this->integer(),
            "dir_name" => $this->string(),
            "file_name" => $this->string(),
            "file_extension" => $this->string(),
            "file_original_name" => $this->string(),
            "file_size" => $this->integer()
        ];
    }


    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            $this->createTable($this->tableName, $this->getColumns());
        }

        $news_dir = Yii::getAlias("@frontend") . "/web/img/news/";
        /** @var News[] $news */
        $news = News::find()->all();

        foreach ($news as $item) {
            if (isset($item->image_name) && $item->image_name && file_exists($news_dir . $item->image_name)) {
                $extensions = explode(".", $item->image_name);
                $newsLinks = [
                    "news_id" => $item->id,
                    "dir_name" => Yii::$app->security->generateRandomString(),
                    "file_name" => $item->image_name,
                    "file_extension" => array_pop($extensions),
                    "file_original_name" => $item->image_name,
                    "file_size" => filesize($news_dir . $item->image_name)
                ];

                if ($this->db->createCommand()->insert($this->tableName, $newsLinks)->execute() > 0) {
                    $dir_name = $news_dir . $newsLinks["dir_name"] . DIRECTORY_SEPARATOR;
                    if (FileHelper::createDirectory($dir_name)) {
                        copy($news_dir . $item->image_name, $dir_name . $item->image_name);
                    }
                }
            }
        }

//        $newsTable = $this->db->getTableSchema("news", true);
//        if (isset($newsTable->columns["image_name"]))
//            $this->dropColumn("news", "image_name");


    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $table = $this->db->getTableSchema($this->tableName, true);
        if ($table) {
            $this->dropTable($this->tableName);
        }

    }

}
