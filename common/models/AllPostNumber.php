<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "all_post_number".
 *
 * @property int $id
 * @property string $post_number
 * @property double $lat
 * @property double $lon
 * @property string $city
 * @property string $municipal_name
 * @property string $municipal_g_name
 * @property string $area
 * @property string $neighbourhood
 */
class AllPostNumber extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'all_post_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat', 'lon'], 'number'],
            [['post_number', 'city', 'municipal_name', 'municipal_g_name', 'area', 'neighbourhood'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_number' => 'Post Number',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'city' => 'City',
            'municipal_name' => 'Municipal Name',
            'municipal_g_name' => 'Municipal G Name',
            'area' => 'Area',
            'neighbourhood' => 'Neighbourhood'
        ];
    }
}
