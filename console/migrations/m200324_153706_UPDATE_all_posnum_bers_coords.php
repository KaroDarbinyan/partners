<?php

use yii\db\Migration;

/**
 * Class m200324_153706_UPDATE_all_posnum_bers_coords
 */
class m200324_153706_UPDATE_all_posnum_bers_coords extends Migration
{
    private $tableName = 'all_post_number';
    /**
     * {@inheritdoc}
     * @throws \Matrix\Exception
     * @throws \yii\base\Exception
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $this->truncateTable($this->tableName);
        Yii::$app->db->createCommand(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "sqls" . DIRECTORY_SEPARATOR . "all_post_number-updated-coords.sql"))->execute();

    }
    /**
     * {@inheritdoc}
     */
    public function __safeUp()
    {
        $storeFile = "webmegler-data" . DIRECTORY_SEPARATOR . "google-map-geocode.json";
        $urlMockoup = "https://geocode.search.hereapi.com/v1/geocode?qq=postalCode={{postCode}};country=NO&apiKey=NG-93QfqDWoIRwJOMrnKnjw5RGj2NTP-ZZRrM2RMWwc";
        $file = json_decode(file_get_contents($storeFile),true);

        $json = ['items'=> ($file && isset($file['items'])) ? $file['items'] : []];
        $p = \common\models\AllPostNumber::find()->orderBy('id')->all();
        /** @var \common\models\AllPostNumber[] $p */
        $buggedUrls = [];
        foreach ($p as $post) {
            $post->post_number = sprintf("%04s", $post->post_number);
            $url = str_replace(
                '{{postCode}}',
                urlencode("{$post->post_number} {$post->city}"),
                $urlMockoup
            );
            $r = json_decode(file_get_contents($url),true);
            if (!isset($r['items']) || !count($r['items'])) {
                $this->delete($this->tableName, ['id'=>$post->id]);
                $buggedUrls[] = $url;
                continue;
            }
            $r = $r['items'][0];
            $json['items'][] = $r;
            $post->lat = $r['position']['lat'];
            $post->lon = $r['position']['lng'];
            $this->update(\common\models\AllPostNumber::tableName(),[
                    'lat'=>$post->lat,
                    'lon'=>$post->lon,
                ],
                ['id'=>$post->id]
            );
        }
        file_put_contents($storeFile,json_encode($json));
        file_put_contents("webmegler-data" . DIRECTORY_SEPARATOR . "google-map-geocode-bugged-urls.json",json_encode($buggedUrls));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200324_153706_UPDATE_all_posnum_bers_coords cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200324_153706_UPDATE_all_posnum_bers_coords cannot be reverted.\n";

        return false;
    }
    */
}
