<?php

namespace api\modules\mobile\modules\v1\models;


use \yii\db\ActiveRecord;

/**
 * This is the model class for table "property_neighbourhood".
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property int $distance
 * @property int $property_web_id
 *
 * @property Property $propertyWeb
 */
class PropertyNeighbourhood extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_neighbourhood';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distance', 'property_web_id'], 'integer'],
            [['type', 'name', 'percent_text_data'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'distance' => 'Distance',
            'property_web_id' => 'Property Web ID',
            'percent_text_data' => 'Percent Text Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyWeb()
    {
        return $this->hasOne(Property::className(), ['web_id' => 'property_web_id']);
    }
}
