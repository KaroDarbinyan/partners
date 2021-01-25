<?php

use yii\db\Migration;
use common\models\AllPostNumber;
/**
 * Class m190509_084117_UPDATE_all_post_numbers_coordinates
 */
class m190509_084117_UPDATE_all_post_numbers_coordinates extends Migration
{
    private $sourceUrl = "http://mapit.nuug.no/";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fCount = 0;
        $posts = AllPostNumber::find()->all();
        foreach ($posts as $post) {
            /* @var $post AllPostNumber */
            echo "{$post->index} ";
            $postJson = @file_get_contents("http://mapit.nuug.no/postcode/{$post->index}.json");
            if ($postJson  === false){
                echo "false";
                $fCount++;
            }else{
                $postJson = json_decode( $postJson, true);
                $post->lat = $postJson['wgs84_lat'];
                $post->lon = $postJson['wgs84_lon'];
                $post->save();
            }
            echo "\n";

        }
        echo "unchanged: {$fCount}";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190509_084117_UPDATE_all_post_numbers_coordinates cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190509_084117_UPDATE_all_post_numbers_coordinates cannot be reverted.\n";

        return false;
    }
    */
}
