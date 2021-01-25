<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "webmegler_contacts".
 *
 * @property int $id__
 * @property string $id
 * @property string $har_tilgang_til_detaljer
 * @property string $kontakttype
 * @property string $id_kontakter__ny
 * @property string $id_kunder
 * @property string $fornavn
 * @property string $etternavn
 * @property string $firmanavn
 * @property string $organisasjonsnummer
 * @property string $adresse
 * @property string $postnummer
 * @property string $poststed
 * @property string $land
 * @property string $nyadresse
 * @property string $nypostnummer
 * @property string $nypoststed
 * @property string $nyadressefradato
 * @property string $nyland
 * @property string $email
 * @property string $telefon
 * @property string $mobiltelefon
 * @property string $personnummer
 * @property string $fodselsdato
 * @property string $id_ansatte__registrertav
 * @property string $id_ansatte__endretav
 * @property string $endretdato
 * @property string $registrertdato
 * @property string $relatertegrupper
 * @property string $budgiveroppdrag
 * @property string $andrekontakteroppdrag
 * @property string $interessentoppdrag
 * @property string $selgerkjoperoppdrag
 * @property string $samtykkeregistreringer
 */
class WebmeglerContacts extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webmegler_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'har_tilgang_til_detaljer', 'kontakttype', 'id_kontakter__ny', 'id_kunder', 'fornavn', 'etternavn', 'firmanavn', 'organisasjonsnummer', 'adresse', 'postnummer', 'poststed', 'land', 'nyadresse', 'nypostnummer', 'nypoststed', 'nyadressefradato', 'nyland', 'email', 'telefon', 'mobiltelefon', 'personnummer', 'fodselsdato', 'id_ansatte__registrertav', 'id_ansatte__endretav', 'endretdato', 'registrertdato', 'relatertegrupper', 'budgiveroppdrag', 'andrekontakteroppdrag', 'interessentoppdrag', 'samtykkeregistreringer'], 'string', 'max' => 255],
            [['selgerkjoperoppdrag'], 'string', 'max' => 1024],
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
            'har_tilgang_til_detaljer' => 'Har Tilgang Til Detaljer',
            'kontakttype' => 'Kontakttype',
            'id_kontakter__ny' => 'Id Kontakter Ny',
            'id_kunder' => 'Id Kunder',
            'fornavn' => 'Fornavn',
            'etternavn' => 'Etternavn',
            'firmanavn' => 'Firmanavn',
            'organisasjonsnummer' => 'Organisasjonsnummer',
            'adresse' => 'Adresse',
            'postnummer' => 'Postnummer',
            'poststed' => 'Poststed',
            'land' => 'Land',
            'nyadresse' => 'Nyadresse',
            'nypostnummer' => 'Nypostnummer',
            'nypoststed' => 'Nypoststed',
            'nyadressefradato' => 'Nyadressefradato',
            'nyland' => 'Nyland',
            'email' => 'Email',
            'telefon' => 'Telefon',
            'mobiltelefon' => 'Mobiltelefon',
            'personnummer' => 'Personnummer',
            'fodselsdato' => 'Fodselsdato',
            'id_ansatte__registrertav' => 'Id Ansatte Registrertav',
            'id_ansatte__endretav' => 'Id Ansatte Endretav',
            'endretdato' => 'Endretdato',
            'registrertdato' => 'Registrertdato',
            'relatertegrupper' => 'Relatertegrupper',
            'budgiveroppdrag' => 'Budgiveroppdrag',
            'andrekontakteroppdrag' => 'Andrekontakteroppdrag',
            'interessentoppdrag' => 'Interessentoppdrag',
            'selgerkjoperoppdrag' => 'Selgerkjoperoppdrag',
            'samtykkeregistreringer' => 'Samtykkeregistreringer',
        ];
    }
}
