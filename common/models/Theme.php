<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "theme".
 *
 * @property int $id
 * @property string $title
 * @property string $color
 * @property string $hex
 * @property string $filename
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'theme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'color', 'hex', 'filename'], 'required'],
            [['title', 'color', 'hex', 'filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'color' => 'Color',
            'hex' => 'Hex',
            'filename' => 'Filename',
        ];
    }
}
