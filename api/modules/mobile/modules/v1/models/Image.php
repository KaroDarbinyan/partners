<?php

namespace api\modules\mobile\modules\v1\models;

use Yii;
use Yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "image".
 *
 * @property int $nr
 * @property int $propertyDetailId
 * @property int $id
 * @property string $urlstorthumbnail
 * @property string $storthumbnailfil
 * @property string $urloriginalbilde
 * @property string $originalbildefil
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
     * @return ActiveQuery
     */
    public function getPropertyDetail()
    {
        return $this->hasOne(PropertyDetails::className(), ['id' => 'propertyDetailId']);
    }
}
