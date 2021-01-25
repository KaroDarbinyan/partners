<?php

namespace api\modules\mobile\modules\v1\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property int $id_firma
 * @property string $navn
 * @property string $organisasjonsnummer
 * @property string $besoksadresse
 * @property string $postnummer
 * @property string $poststed
 * @property string $telefon
 * @property string $telefax
 * @property string $email
 * @property string $inaktiv
 * @property string $dagligleder
 * @property string $avdelingsleder
 * @property string $fagansvarlig
 * @property string $short_name
 * @property string $url
 *
 * @property User[] $users
 * @property User $director
 * @property int $web_id
 * @property string $part_of_city
 * @property PropertyDetails[] $properties
 */
class Department extends ActiveRecord
{

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['department_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(PropertyDetails::class, ['avdeling_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDirector()
    {
        return $this->hasOne(User::className(), ['web_id' => 'avdelingsleder']);
    }


}
