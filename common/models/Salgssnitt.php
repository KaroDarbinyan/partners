<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "salgssnitt".
 *
 * @property int $id
 * @property int $year
 * @property int $month
 * @property double $value
 * @property int $created_at
 * @property int $updated_at
 */
class Salgssnitt extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salgssnitt';
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
            [['year', 'month', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'month' => 'Month',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public static function getAllYears()
    {
        $salgssnitt = [];
        $salgssnitts = self::find()
            ->asArray()
            ->all();

        foreach ($salgssnitts as $item) {
            $salgssnitt[$item['year']][$item['month']] = $item['value'];
        }

        return $salgssnitt;
    }

}
