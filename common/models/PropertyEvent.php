<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%properties_events}}".
 *
 * @property int $id
 * @property int $property_id
 * @property int $event_id
 * @property string $start_time
 * @property string $end_time
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CalendarEvent $event
 * @property PropertyDetails $property
 */
class PropertyEvent extends ActiveRecord
{

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%properties_events}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'event_id', 'created_at', 'updated_at'], 'integer'],
            [['start_time', 'end_time'], 'string', 'max' => 255],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarEvent::class, 'targetAttribute' => ['event_id' => 'id']],
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
            'event_id' => Yii::t('app', 'Event ID'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(CalendarEvent::class, ['id' => 'event_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'property_id']);
    }

    /**
     * {@inheritdoc}
     * @return PropertyEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyEventQuery(get_called_class());
    }
}
