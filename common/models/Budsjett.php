<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "budsjett".
 *
 * @property int $id
 * @property int $user_id
 * @property int $inntekt
 * @property int $snittprovisjon
 * @property int $hitrate
 * @property int $befaringer
 * @property int $salg
 * @property int $year
 * @property int $created_at
 * @property int $updated_at
 * @property int $avdeling_id
 */
class Budsjett extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budsjett';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
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
            [['user_id'], 'required'],
            [['user_id', 'inntekt', 'snittprovisjon', 'hitrate', 'befaringer', 'salg', 'year', 'created_at', 'updated_at','avdeling_id'], 'integer'],
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
            'inntekt' => 'Inntekt',
            'snittprovisjon' => 'Snittprovisjon',
            'hitrate' => 'Hitrate',
            'befaringer' => 'Befaringer',
            'salg' => 'Salg',
            'year' => 'Year',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'avdeling_id' => 'Avdeling Id',
        ];
    }

    public static function getBudsjettsByYear($year)
    {
        return self::find()
            ->select([
                'SUM(befaringer) as befaringer',
                'SUM(salg) as salg',
                'SUM(inntekt) as inntekt'
            ])
            ->where(['IN', 'year', $year])
            ->asArray()->one();
    }
}
