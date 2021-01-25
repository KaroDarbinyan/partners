<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "departments_avdeling".
 *
 * @property int $id__
 * @property string $id
 * @property string $id_firma
 * @property string $navn
 * @property string $juridisknavn
 * @property string $organisasjonsnummer
 * @property string $urlhtmlpresentasjon_avdeling
 * @property string $urlhtmlpresentasjon_konsern
 * @property string $logo_url
 * @property string $besoksadresse
 * @property string $postadresse
 * @property string $postnummer
 * @property string $poststed
 * @property string $telefon
 * @property string $telefax
 * @property string $email
 * @property string $hjemmeside
 * @property string $inaktiv
 * @property string $dagligleder
 * @property string $avdelingsleder
 * @property string $fagansvarlig
 * @property string $superbruker
 * @property string $bilder
 * @property string $fritekster
 */
class DepartmentsAvdeling extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments_avdeling';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_firma', 'navn', 'juridisknavn', 'organisasjonsnummer', 'urlhtmlpresentasjon_avdeling', 'urlhtmlpresentasjon_konsern', 'logo_url', 'besoksadresse', 'postadresse', 'postnummer', 'poststed', 'telefon', 'telefax', 'email', 'hjemmeside', 'inaktiv'], 'string', 'max' => 255],
            [['dagligleder', 'avdelingsleder', 'fagansvarlig', 'superbruker', 'bilder', 'fritekster'], 'string', 'max' => 1024],
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
            'id_firma' => 'Id Firma',
            'navn' => 'Navn',
            'juridisknavn' => 'Juridisknavn',
            'organisasjonsnummer' => 'Organisasjonsnummer',
            'urlhtmlpresentasjon_avdeling' => 'Urlhtmlpresentasjon Avdeling',
            'urlhtmlpresentasjon_konsern' => 'Urlhtmlpresentasjon Konsern',
            'logo_url' => 'Logo Url',
            'besoksadresse' => 'Besoksadresse',
            'postadresse' => 'Postadresse',
            'postnummer' => 'Postnummer',
            'poststed' => 'Poststed',
            'telefon' => 'Telefon',
            'telefax' => 'Telefax',
            'email' => 'Email',
            'hjemmeside' => 'Hjemmeside',
            'inaktiv' => 'Inaktiv',
            'dagligleder' => 'Dagligleder',
            'avdelingsleder' => 'Avdelingsleder',
            'fagansvarlig' => 'Fagansvarlig',
            'superbruker' => 'Superbruker',
            'bilder' => 'Bilder',
            'fritekster' => 'Fritekster',
        ];
    }
}
