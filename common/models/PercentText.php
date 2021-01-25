<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "percent_text".
 *
 * @property int $id
 * @property int $number
 * @property string $name
 * @property int $value
 * @property int $property_web_id
 *
 * @property PropertyDetails $propertyWeb
 */
class PercentText extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'percent_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'value', 'property_web_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['property_web_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyDetails::className(), 'targetAttribute' => ['property_web_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'name' => 'Name',
            'value' => 'Value',
            'property_web_id' => 'Property Web ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(PropertyDetails::className(), ['id' => 'property_web_id']);
    }
}
