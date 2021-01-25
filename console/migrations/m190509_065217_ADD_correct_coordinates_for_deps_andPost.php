<?php

use yii\db\Migration;
use common\models\Department;
use common\models\AllPostNumber;

/**
 * Class m190509_065217_ADD_correct_coordinates_for_deps_andPost
 */
class m190509_065217_ADD_correct_coordinates_for_deps_andPost extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $deps = Department::find()
            ->joinWith('postNumberDetails')
            ->all()
        ;
        $coords = [
            '0565' => [59.92447,  10.77265],
            '0950' => [59.9481,   10.86256],
            '0506' => [59.91876,  10.76156],
            '0505' => [59.92221,  10.75718],
            '0461' => [59.934962, 10.753287],
            '0474' => [59.93106,  10.76623],
            '0001' => [59.9116,   10.7545],
        ];

        foreach ($coords as $key => $v) {
            $post = AllPostNumber::findOne(['index'=> $key]);
            $post->lat = $v[0];
            $post->lon = $v[1];
            $post->save();
        }
        $post = AllPostNumber::findOne(['index'=> '0001']);
        $post->lat = $coords['0001'][0];
        $post->lon = $coords['0001'][1];
        $post->save();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190509_065217_ADD_correct_coordinates_for_deps_andPost cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190509_065217_ADD_correct_coordinates_for_deps_andPost cannot be reverted.\n";

        return false;
    }
    */
}
