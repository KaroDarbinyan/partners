<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

// TODO: add all relations to comments as @property
/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $leader_id
 * @property string $url
 * @property int $wapi_id
 * @property string $logo
 * @property string $address
 * @property string $email
 * @property string $telefon
 * @property string $bolignytt
 * @property string $description
 * @property string $head_stack
 *
 * @property PropertyDetails[] $properties
 * @property User[] $users
 * @property Department[] $department
 * @property PartnerSettings $partnerSettings
 */

class Partner extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leader_id', 'wapi_id'], 'integer'],
            [['description', 'head_stack'], 'string'],
            [['name', 'slug', 'url', 'email'], 'string', 'max' => 255],
            [['logo', 'address', 'bolignytt'], 'string', 'max' => 1024],
            [['telefon'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'leader_id' => 'Leader ID',
            'url' => 'Url',
            'wapi_id' => 'Webmegler Api ID',
            'logo' => 'Logo',
            'address' => 'Address',
            'email' => 'Email',
            'telefon' => 'Telefon',
            'bolignytt' => 'Bolignytt',
            'description' => 'Description',
            'head_stack' => 'Meta tags, scripts and styles'
        ];
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id_avdelinger' => 'web_id'])
            ->viaTable(Department::tableName(), ['partner_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasMany(Department::class, ["partner_id" => "id"])
            ->onCondition(['department.inaktiv' => 0])->orderBy(['short_name' => SORT_ASC]);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getProperties()
    {
        return $this->hasMany(PropertyDetails::className(), ['avdeling_id' => 'web_id'])
            ->viaTable(Department::tableName(), ['partner_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getActiveDepartments()
    {
        return $this->hasMany(Department::class, ['partner_id' => 'id'])
            ->onCondition(['partnerDepartments.inaktiv' => 0])
            ->alias('partnerDepartments');
    }

    /**
     * @return ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::class, ["partner_id" => "id"])->onCondition(['department.inaktiv' => 0]);
    }

    /**
     * @return array
     */
    public function getDepartmentsWebId()
    {
        return $this->hasMany(Department::class, ["partner_id" => "id"])
            ->select(["web_id"])->onCondition(['department.inaktiv' => 0])->column();
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getAll()
    {
        return self::find()->joinWith(["department" => function(ActiveQuery $query){
            $query->where(['department.inaktiv' => 0]);
        }])
            ->asArray()->all();

    }

    /**
     * @return ActiveQuery
     */
    public function getPartnerToNews()
    {
        return $this->hasMany(DepartmentToNews::class, ['partner_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ["id" => "news_id"])->via("partnerToNews")->all();
    }

    /**
     * Get all departments id's.
     *
     * @return array
     */
    public function getDepartmentsIds()
    {
        return $this->getActiveDepartments()
            ->select('web_id')
            ->asArray()
            ->column();
    }

    /**
     * Get the budget for all departments.
     *
     * @param array $year
     *
     * @return array|ActiveRecord|null
     */
    public function getDepartmentsBudget(array $year)
    {
        $departments = $this->getDepartmentsIds();

        return Budsjett::find()
            ->select([
                'SUM(befaringer) as befaringer',
                'SUM(salg) as salg',
                'SUM(inntekt) as inntekt'
            ])
            ->where([
                'avdeling_id' => $departments,
                'year' => $year
            ])
            ->asArray()
            ->one();
    }
    /**
     * @param $year
     * @return array|ActiveRecord|null
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
            ->andWhere(['in', 'avdeling_id', $this->departmentsWebId]);

        return $budsjett->asArray()->one();
    }

    /**
     * @param int $partnerId
     * @param array $except
     * @return User[]
     */
    public static function getAnsatteUsersData($partnerId = null, $except = [])
    {
        return User::find()
            ->joinWith('department')
            ->where(['not in', 'id', $except])
            ->andWhere(['department.partner_id' => $partnerId, 'user.inaktiv_status' => -1])
            ->orderBy(new Expression('rand()'))
            ->all();
    }


    /**
     * @return ActiveQuery
     */
    public function getPartnerSettings()
    {
        return $this->hasOne(PartnerSettings::class, ["partner_id" => "id"]);
    }

}
