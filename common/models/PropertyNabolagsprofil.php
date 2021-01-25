<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_nabolagsprofil".
 *
 * @property int $id
 * @property string $percent_text_data
 * @property int $property_web_id
 */
class PropertyNabolagsprofil extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_nabolagsprofil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percent_text_data'], 'string'],
            [['property_web_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'percent_text_data' => 'Percent Text Data',
            'property_web_id' => 'Property Web ID',
        ];
    }
}
