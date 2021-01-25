<?php

use common\models\News;
use yii\db\Migration;

/**
 * Class m200416_122818_update_image_name_news_table
 */
class m200416_122818_update_image_name_news_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $news = News::find()->all();

        foreach ($news as $item) {
            if ($item->image_name) {
                News::updateAll(["image_name" => str_replace("/", "", $item->image_name)]);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $news = News::find()->all();

        foreach ($news as $item) {
            if ($item->image_name) {
                News::updateAll(["image_name" => "/{$item->image_name}"]);
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
        echo "m200416_122818_update_image_name_news_table cannot be reverted.\n";

        return false;
    }
    */
}
