<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_test".
 *
 * @property int $id
 * @property int $key
 * @property string $message
 * @property int $b
 * @property int $l
 * @property int $o
 * @property int $d
 */
class LogTest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'b', 'l', 'o', 'd'], 'integer'],
            [['message'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'message' => 'Message',
            'b' => 'B',
            'l' => 'L',
            'o' => 'O',
            'd' => 'D',
        ];
    }
}
