<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "webmegler_employees".
 *
 * @property int $id__
 * @property string $id
 * @property string $avdeling_id
 * @property string $navn
 * @property string $tittel
 * @property string $inaktiv
 * @property string $mobiltelefon
 * @property string $email
 */
class WebmeglerEmployees extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webmegler_employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'avdeling_id', 'navn', 'tittel', 'inaktiv', 'mobiltelefon', 'email'], 'string', 'max' => 255],
            [ 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id__' => 'Id',
            'id' => 'ID',
            'avdeling_id' => 'Id Avdelinger',
            'navn' => 'Navn',
            'tittel' => 'Tittel',
            'inaktiv' => 'Inaktiv',
            'mobiltelefon' => 'Mobiltelefon',
            'email' => 'Email',
        ];
    }
}
