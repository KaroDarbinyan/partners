<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "signatur".
 *
 * @property int $id
 * @property string $left_content
 * @property string $right_content
 * @property string $user_id
 */
class Signatur extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'signatur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['left_content', 'right_content'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
        ];
    }

}
