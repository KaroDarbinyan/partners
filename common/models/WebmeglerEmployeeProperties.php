<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "webmegler_employee_properties".
 *
 * @property int $id__
 * @property string $id
 * @property string $oppdragsnummer
 * @property string $markedsforingsklart
 * @property string $type_oppdragstatus
 * @property string $adresse
 */
class WebmeglerEmployeeProperties extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webmegler_employee_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'oppdragsnummer', 'markedsforingsklart', 'type_oppdragstatus', 'adresse'], 'string', 'max' => 255],
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
            'oppdragsnummer' => 'Oppdragsnummer',
            'markedsforingsklart' => 'Markedsforingsklart',
            'type_oppdragstatus' => 'Type Oppdragstatus',
            'adresse' => 'Adresse',
        ];
    }
}
