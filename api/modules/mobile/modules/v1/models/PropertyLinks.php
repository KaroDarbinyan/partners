<?php

namespace api\modules\mobile\modules\v1\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_links".
 *
 * @property int $id
 * @property string $navn
 * @property string $url
 * @property string $property_web_id
 * @property string $type
 *
 * @property Property $property
 */
class PropertyLinks extends ActiveRecord
{

    /**
     * @return ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['web_id' => 'property_web_id']);
    }

    /**
     * Check is the array of data for the correct doc type
     * @param array $data assoc array of data from webmegler
     * @return bool
     */
    public static function isRightLink($data)
    {
        return (
            isset($data['navn'])
            &&(
                strpos($data['navn'], 'Digitalformat Salgsoppgave -') !== false
                || strpos($data['navn'], 'Interaktiv Nabolagsprofil') !== false
            )
        );
    }
}
