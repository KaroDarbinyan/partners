<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_links".
 *
 * @property int $id
 * @property string $navn
 * @property string $url
 * @property string $property_web_id
 * @property string $type
 *
 * @property PropertyDetails $property
 */
class PropertyLinks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_web_id'], 'integer'],
            [['navn', 'url'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'navn' => 'Navn',
            'url' => 'Url',
            'property_web_id' => 'Property Web ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'property_web_id']);
    }

    /**
     * Check is the array of data for the correct doc type
     * @param array $data assoc array of data from webmegler
     * @return bool
     */
    public static function isRightLink($data)
    {
        return (
            isset($data['navn'])
            &&(
                strpos($data['navn'], 'Digitalformat Salgsoppgave -') !== false
                || strpos($data['navn'], 'Interaktiv Nabolagsprofil') !== false
            )
        );
    }
}
