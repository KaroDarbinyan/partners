<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_basket".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $count
 * @property int $created_at
 * @property int $updated_at
 */
class ShopBasket extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_basket';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'count', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(ShopProduct::class, ['id' => 'product_id']);
    }

}
