<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/* @property PropertyDetails $property */

final class Boligvarsling extends ActiveRecord
{
    public $totalSubscriptions;
    public $agree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'boligvarsling';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cost_from', 'cost_to', 'area_from', 'area_to', 'map_radius'], 'integer'],
            [['domain', 'phone'], 'string'],
            [['map_lat', 'map_lng'], 'double'],
            ['subscribe', 'boolean'],
            [['email'], 'email'],
            [['property_type', 'rooms', 'criterions'], 'each', 'rule' => ['string']],
            [['region'], 'isArray'],
            ['region', 'required', 'when' => function ($model) {
                $mapEnabled = ArrayHelper::getValue(\Yii::$app->request->post('circle'), 'enable');

                return is_null($mapEnabled) || $mapEnabled === 'off';
            }],
            //[['phone'], PhoneInputValidator::class, 'region' => ['NO']],
            [['property_type', 'phone', 'name'], 'required'],
            [['email'], 'required'],
            ['subscribe', 'compare', 'compareValue' => true, 'message' => 'Abonnement via e-post må sjekkes'],
            ['agree', 'compare', 'compareValue' => true, 'message' => 'Bekreft at du har lest vilkårene'],
            ['subscribe', 'default', 'value' => true],
            ['property_id', 'integer'],
        ];
    }

    /**
     * The boligvarsling belongs to property.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'property_id']);
    }

    /**
     * We accept this array.
     *
     * @param $attribute
     * @param $params
     *
     * @return bool
     */
    public function isArray($attribute, $params)
    {
        return !empty($this->$attribute) && is_array($this->$attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cost_from' => 'Price From',
            'cost_to' => 'Price To',
            'area_from' => 'Area From',
            'area_to' => 'Area To',
            'property_type' => 'Eiendomstype',
            'region' => 'Region',
            'rooms' => 'Rooms',
            'domain' => 'Domain',
            'name' => 'Navn',
            'phone' => 'Telefon',
            'email' => 'Epost',
            'subscribe' => 'Abonner via e-post',
            'notify_at' => 'Notified kl',
            'created_at' => 'Opprettet kl',
            'updated_at' => 'Endret kl',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function isVipPartner()
    {
        return in_array($this->domain, ['partners.no']);
    }

    public function getCostRangeHumanize()
    {
        if ($this->cost_to) {
            return "{$this->cost_from}-{$this->cost_to} NOK";
        }

        return 'ALLE';
    }

    public function getAreaRangeHumanize()
    {
        if ($this->area_to) {
            return "{$this->area_from}-{$this->area_to} m²";
        }

        return 'ALLE';
    }

    public function getPropertyTypesHumanize()
    {
        if ($types = $this->property_type) {
            return join(', ', Json::decode($types));
        }

        return 'ALLE';
    }

    public function getRegionsHumanize()
    {
        if ($this->region && $regions = Json::decode($this->region)) {
            $array = [];

            foreach ($regions as $key => $value) {
                if (is_array($value)) {
                    $array = array_merge($array, $value);
                } else {
                    $array[] = $value;
                }
            }

            return join(', ', $array);
        }

        return 'ALLE';
    }

    public function getRoomsHumanize()
    {
        if ($rooms = $this->rooms) {
            return join(', ', Json::decode($rooms));
        }

        return 'ALLE';
    }
}