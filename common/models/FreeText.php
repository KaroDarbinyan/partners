<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "free_text".
 *
 * @property string $id
 * @property string $propertyDetailId
 * @property int $nr
 * @property int $visinettportaler
 * @property string $gruppenavn
 * @property string $overskrift
 * @property string $htmltekst
 * @property int $compositeTextId
 *
 * @property PropertyDetails $propertyDetail
 */
class FreeText extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'free_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['propertyDetailId', 'nr', 'visinettportaler','compositeTextId',], 'integer'],
            [['gruppenavn', 'overskrift'], 'string', 'max' => 255],
            [['htmltekst'], 'string', 'max' => 2048],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'propertyDetailId' => 'Property Detail ID',
            'nr' => 'Nr',
            'visinettportaler' => 'Visinettportaler',
            'gruppenavn' => 'Gruppenavn',
            'overskrift' => 'Overskrift',
            'htmltekst' => 'Htmltekst',
            'compositeTextId' => 'Composite Text ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyDetail()
    {
        return $this->hasOne(PropertyDetails::className(), ['id' => 'propertyDetailId']);
    }
}
