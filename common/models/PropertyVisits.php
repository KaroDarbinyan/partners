<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
/**
 * This is the model class for table "property_visits".
 *
 * @property int $id
 * @property int $nr
 * @property int $visit_id
 * @property string $fra
 * @property string $til
 * @property int $property_web_id
 *
 * @property string $address
 * @property string $date
 * @property string $propertyHref
 * @property PropertyDetails $propertyDetail
 * @property PropertyDetails[] $propertyDetails
 * @property User $user
 */
class PropertyVisits extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_visits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nr', 'visit_id', 'property_web_id'], 'integer'],
            [['fra', 'til'], 'safe'],
            [['property_web_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyDetails::class, 'targetAttribute' => ['property_web_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nr' => 'Nr',
            'visit_id' => 'Visit ID',
            'fra' => 'Fra',
            'til' => 'Til',
            'property_web_id' => 'Property Web ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['web_id' => 'ansatte1_id'])
            ->via('propertyDetails')
        ;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->propertyDetail->adresse;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getDate()
    {
        Yii::$app->formatter->timeZone = 'Europe/Oslo';

        return Yii::$app->formatter->asDate($this->fra, 'dd.MM / HH:mm');
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getPropertyHref(){
        return Url::toRoute(['oppdrag/detaljer', 'id' => $this->property_web_id]);
    }

    public function getPropertyDetails()
    {
        return $this->hasMany(PropertyDetails::className(),['id'=>'property_web_id']);
    }

    public function getPropertyDetail()
    {
        return $this->hasOne(PropertyDetails::className(),['id'=>'property_web_id']);
    }

}
