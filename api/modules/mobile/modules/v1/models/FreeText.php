<?php

namespace api\modules\mobile\modules\v1\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "free_text".
 *
 * @property string $id
 * @property string $propertyDetailId
 * @property int $nr
 * @property int $visinettportaler
 * @property string $gruppenavn
 * @property string $overskrift
 * @property string $htmltekst
 *
 * @property PropertyDetails $propertyDetail
 */
class FreeText extends ActiveRecord
{

    /**
     * @return ActiveQuery
     */
    public function getPropertyDetail()
    {
        return $this->hasOne(PropertyDetails::className(), ['id' => 'propertyDetailId']);
    }
}
