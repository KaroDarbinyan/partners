<?php

namespace common\models;

use common\models\activeQuery\ShopOrderQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 * @property string $comment
 * @property string $products
 * @property int $department_id
 * @property int $partner_id
 */
class ShopOrder extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_order';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'date'],
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
            [['user_id', 'created_at', 'updated_at', 'department_id', 'partner_id'], 'integer'],
            [['comment', 'products'], 'string'],
            [['status', 'date'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'date' => 'Date',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'comment' => 'Comment',
            'products' => 'Products',
            'department_id' => 'Department',
            'partner' => 'Partner',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ShopOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShopOrderQuery(get_called_class());
    }


}
