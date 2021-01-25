<?php

namespace common\models;

use common\components\Befaring;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property int $id_firma
 * @property string $navn
 * @property int $organisasjonsnummer
 * @property string $besoksadresse
 * @property int $postnummer
 * @property string $poststed
 * @property string $telefon
 * @property string $telefax
 * @property string $email
 * @property int $inaktiv
 * @property int $dagligleder
 * @property int $avdelingsleder
 * @property int $fagansvarlig
 * @property int $web_id
 * @property string $url
 * @property string $short_name
 * @property string $part_of_city
 * @property int $acting
 * @property int $partner_id
 * @property string $bolignytt
 * @property string $description
 * @property int $original_id
 * @property string $brokers
 * @property string $price_list_url
 * @property string $extra_brokers
 * @property string $eiendomsverdi
 *
 * @property User[] $users
 * @property User $directorDeputy
 * @property User[] $ansatteUsers
 * @property PostNumber[] $postNumbers
 * @property AllPostNumber $postNumberDetails
 * @property User $director
 * @property User $user
 * @property Partner $partner
 */
class Department extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_firma', 'organisasjonsnummer', 'postnummer', 'inaktiv', 'dagligleder', 'avdelingsleder', 'fagansvarlig', 'web_id', 'acting', 'partner_id', 'original_id'], 'integer'],
            [['besoksadresse', 'description'], 'string'],
            [['acting'], 'required'],
            [['navn', 'poststed', 'email', 'url', 'short_name', 'part_of_city', 'bolignytt', 'brokers', 'price_list_url', 'extra_brokers'], 'string', 'max' => 255],
            [['telefon', 'telefax'], 'string', 'max' => 30],
            [['eiendomsverdi'], 'string', 'max' => 32],
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
            'navn' => 'Navn',
            'short_name' => 'Kort Navn',
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
            'web_id' => 'Web ID',
            'url' => 'Deparment Url Key',
            'acting' => 'Avdelingsleder acting',
            'partner_id' => 'Partner Id',
            'bolignytt' => 'Bolignytt',
            'eiendomsverdi' => 'Eiendoms verdi',
        ];
    }

    /**
     * {@inheritdoc}
     * @return DepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorized()
    {
        return $this->hasOne(User::class, ['web_id' => 'fagansvarlig']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id_avdelinger' => 'web_id']);
    }

    /**
     * Properties linked to this department.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(PropertyDetails::class, ['avdeling_id' => 'web_id']);
    }


    public function getAnsatteUsers($id_avdelinger = null)
    {
        return User::find()->where(['id_avdelinger'=>$id_avdelinger,'inaktiv_status' => 1])
            ->orWhere(['inaktiv_status' => 1])
            ->orderBy(new Expression('rand()'))
            ->all();
    }

    /**
     * @param int $id_avdelinger
     * @param array $except
     * @return User[]
     */
    public static function getAnsatteUsersData($id_avdelinger = null, $except = [])
    {
        return User::find()
            ->with('department')
            ->where(['not in', 'id', $except])
            ->andWhere(['id_avdelinger' => $id_avdelinger, 'inaktiv_status' => -1])
            ->orderBy(new Expression('rand()'))
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirector()
    {
        return $this->hasOne(User::class, ['web_id' => 'avdelingsleder']);
    }

    /**
     * Director of department.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['web_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirectorDeputy()
    {
        return $this->hasOne(User::class, ['web_id' => 'acting']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForms()
    {
        return $this->hasMany(Forms::className(), ['department_id' => 'web_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getPostNumbers()
    {
        return $this->hasOne(PostNumber::class, ['department_id' => 'web_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostNumberDetails(){
        return $this->hasOne(AllPostNumber::className(), ['post_number' => 'postnummer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::class, ['id' => 'partner_id']);
    }

    /**
     * @param $year
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getBudsjetts($year)
    {
        $budsjett = Budsjett::find()
            ->select([
                'SUM(befaringer) as befaringer',
                'SUM(salg) as salg',
                'SUM(inntekt) as inntekt'
            ])
            ->where(['IN', 'year', $year])
            ->andWhere(['avdeling_id' => $this->web_id]);

        return $budsjett->asArray()->one();
    }

    /**
     * Get the full address of department.
     *
     * @return string
     */
    public function getFullAddress()
    {
        $zip = $this->postnummer;

        Befaring::numFormat($zip);

        return "$this->besoksadresse $zip $this->poststed";
    }


    /**
     * @return ActiveQuery
     */
    public function getDepartmentToNews()
    {
        return $this->hasMany(DepartmentToNews::class, ['department_web_id' => 'web_id']);
    }

    /**
     * @return array
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ["id" => "news_id"])->via("departmentToNews")->all();
    }

    /**
     * Determine flag if is administration.
     *
     * @return bool
     */
    public function isAdministration()
    {
        return in_array($this->id, [90]);
    }

}
