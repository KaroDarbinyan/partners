<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_ads".
 *
 * @property int $id
 * @property string $finn_adid
 * @property string $finn_viewings
 * @property string $finn_emails
 * @property string $finn_general_emails
 * @property int $eiendom_viewings
 * @property int $adv_in_fb
 * @property int $adv_in_insta
 * @property int $adv_in_video
 * @property int $adv_in_solgt
 * @property int $property_id
 */
class PropertyAds extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eiendom_viewings', 'adv_in_fb', 'adv_in_insta', 'adv_in_video', 'adv_in_solgt', 'property_id'], 'integer'],
            [['finn_adid', 'finn_viewings', 'finn_emails', 'finn_general_emails'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'finn_adid' => 'Finn Adid',
            'finn_viewings' => 'Finn Viewings',
            'finn_emails' => 'Finn Emails',
            'finn_general_emails' => 'Finn General Emails',
            'eiendom_viewings' => 'Eiendom Viewings',
            'adv_in_fb' => 'Adv In Fb',
            'adv_in_insta' => 'Adv In Insta',
            'adv_in_video' => 'Adv In Video',
            'adv_in_solgt' => 'Adv In Solgt',
            'property_id' => 'Property ID',
        ];
    }

    public function getPropertyDetails()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'property_id']);
    }

}
