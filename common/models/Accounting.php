<?php

namespace common\models;

use common\models\activeQuery\AccountingQuery;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "accounting".
 *
 * @property int $id
 * @property int $id_firma
 * @property string $firma
 * @property int $bilagsnummer
 * @property int $bilagsdato
 * @property int $endretdato
 * @property int $linjenummer
 * @property int $id_avdelinger
 * @property string $avdeling
 * @property int $id_ansatte
 * @property string $ansatt
 * @property int $oppdragsnummer
 * @property string $adresse
 * @property int $konto
 * @property string $kontonavn
 * @property string $kommentar
 * @property string $belop
 *
 *
 * @property Department $department
 * @property User $user
 */
class Accounting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accounting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_firma', 'bilagsnummer', 'bilagsdato', 'endretdato', 'linjenummer', 'id_avdelinger', 'id_ansatte', 'oppdragsnummer', 'konto', 'db_id'], 'integer'],
            [['kommentar'], 'string'],
            [['firma', 'avdeling', 'ansatt', 'adresse', 'kontonavn', 'belop'], 'string', 'max' => 255],
            [['bilagsnummer', 'linjenummer'], 'unique', 'targetAttribute' => ['bilagsnummer', 'linjenummer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_firma' => 'Id Firma',
            'firma' => 'Firma',
            'bilagsnummer' => 'Bilagsnummer',
            'bilagsdato' => 'Bilagsdato',
            'endretdato' => 'Endretdato',
            'linjenummer' => 'Linjenummer',
            'id_avdelinger' => 'Id Avdelinger',
            'avdeling' => 'Avdeling',
            'id_ansatte' => 'Id Ansatte',
            'ansatt' => 'Ansatt',
            'oppdragsnummer' => 'Oppdragsnummer',
            'adresse' => 'Adresse',
            'konto' => 'Konto',
            'kontonavn' => 'Kontonavn',
            'kommentar' => 'Kommentar',
            'belop' => 'Belop',
            'db_id' => 'Db ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ["web_id" => "id_avdelinger"]);
    }


    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ["web_id" => "id_ansatte"]);
    }


    /**
     * @return AccountingQuery|ActiveQuery
     */
    public static function find()
    {
        return new AccountingQuery(get_called_class());
    }
}
