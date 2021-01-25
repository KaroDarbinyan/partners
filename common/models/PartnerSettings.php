<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "partner_settings".
 *
 * @property int $id
 * @property string $property_view
 * @property int $active
 * @property int $partner_id
 */
class PartnerSettings extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_view'], 'string'],
            [['active', 'partner_id'], 'integer'],
            [['partner_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_view' => 'Property View',
            'active' => 'Active',
            'partner_id' => 'Partner ID',
        ];
    }
}
