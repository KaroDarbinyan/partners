<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_aktiviteter".
 *
 * @property int $id
 * @property int $user_id
 * @property string $year
 * @property string $month
 * @property string $data
 */
class UserAktiviteter extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_aktiviteter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['data'], 'string'],
            [['year', 'month'], 'string', 'max' => 4],
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
            'year' => 'Year',
            'month' => 'Month',
            'data' => 'Data',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
