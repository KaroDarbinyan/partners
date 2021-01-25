<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%property_print}}".
 *
 * @property int $id
 * @property int $property_id
 * @property string $comment
 *
 * @property PropertyDetails $property
 */
class PropertyPrint extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id'], 'integer'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyDetails::class, 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'property_id']);
    }
}
