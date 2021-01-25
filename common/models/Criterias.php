<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "criterias".
 *
 * @property int $id
 * @property int $property_web_id
 * @property int $id_typer
 * @property string $navn
 * @property string $iadnavn
 * @property int $db_id
 */
class Criterias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'criterias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_web_id', 'id_typer', 'db_id'], 'integer'],
            [['navn', 'iadnavn'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_web_id' => 'Property Web ID',
            'id_typer' => 'Id Typer',
            'navn' => 'Navn',
            'iadnavn' => 'Iadnavn',
            'db_id' => 'Db ID',
        ];
    }
}
