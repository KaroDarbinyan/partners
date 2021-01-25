<?php

namespace common\models;

use common\components\CdnComponent;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "image".
 *
 * @property int $nr
 * @property int $propertyDetailId
 * @property int $id
 * @property string $urlstorthumbnail
 * @property string $urloriginalbilde
 * @property string $overskrift
 * @property string $type_navn
 * @property string $width
 * @property string $height
 *
 * @property PropertyDetails $propertyDetail
 */
class Image extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nr', 'propertyDetailId'], 'integer'],
            [['urlstorthumbnail', 'urloriginalbilde', 'overskrift', 'type_navn', 'width', 'height'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nr' => 'Nr',
            'propertyDetailId' => 'Property Detail ID',
            'id' => 'ID',
            'urlstorthumbnail' => 'Urlstorthumbnail',
            'urloriginalbilde' => 'Urloriginalbilde',
            'overskrift' => 'Overskrift',
            'type_navn' => 'Type Navn',
            'width' => 'Width',
            'height' => 'Height',
        ];
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getPropertyDetail()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'propertyDetailId']);
    }

    /**
     * Get the path to image.
     *
     * @param string $width
     * @param string $height
     *
     * @return string
     */
    public function path($width = '', $height = '')
    {
        return CdnComponent::optimizedUrl($this->urlstorthumbnail ?? $this->urloriginalbilde, $width, $height);
    }
}
