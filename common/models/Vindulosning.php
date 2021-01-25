<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vindulosning".
 *
 * @property int $id
 * @property string $view
 * @property string $property_ids
 * @property int $user_id
 * @property int $column
 * @property int $active
 * @property int $created_at
 * @property int $updated_at
 */
class Vindulosning extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vindulosning';
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
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_ids', 'user_id', 'column'], 'required'],
            [['user_id', 'column', 'active', 'created_at', 'updated_at'], 'integer'],
            [['view', 'property_ids'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'view' => 'View',
            'property_ids' => 'Property Ids',
            'user_id' => 'User ID',
            'column' => 'Column',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
