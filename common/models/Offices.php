<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "offices".
 *
 * @property int $id
 * @property string $name
 *
 * @property PostNumber[] $postNumbers
 */
class Offices extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostNumbers()
    {
        //TODO:discuss what should we do here
        return $this->hasMany(PostNumber::className(), ['offices_id' => 'id']);
    }
}
