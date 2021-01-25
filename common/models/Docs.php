<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%docs}}".
 *
 * @property string $id
 * @property string $urldokument
 * @property string $filtype
 * @property string $navn
 * @property string $property_web_id
 */
class Docs extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%docs}}';
    }

    /**
     * Check is the array of data for the correct doc type
     * @param array $data assoc array of data from webmegler
     * @return bool
     */
    public static function isRightDoc($data)
    {
        return (
            isset($data['navn'])
            && $data['navn'] == 'Nabolagsprofil JSON'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urldokument'], 'string'],
            [['property_web_id', 'web_id', 'typeid', 'nettpublisert', 'autoprospekt'], 'integer'],
            [['filtype'], 'string', 'max' => 10],
            [['navn'], 'string', 'max' => 255],
            [['type_dokumentkategorier'], 'string', 'max' => 50],
            [['property_web_id', 'web_id'], 'unique', 'targetAttribute' => ['property_web_id', 'web_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'urldokument' => 'Urldokument',
            'filtype' => 'Filtype',
            'navn' => 'Navn',
            'property_web_id' => 'Property Web ID',
            'web_id' => 'Web ID',
            'type_dokumentkategorier' => 'Type Dokumentkategorier',
            'typeid' => 'Typeid',
            'nettpublisert' => 'Nettpublisert',
            'autoprospekt' => 'Autoprospekt',
        ];
    }
}
