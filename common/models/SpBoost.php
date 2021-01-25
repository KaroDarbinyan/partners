<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "sp_boost".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property string $partner_ids
 */
class SpBoost extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_boost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['partner_ids'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'partner_ids' => 'Partner Ids',
        ];
    }
}
