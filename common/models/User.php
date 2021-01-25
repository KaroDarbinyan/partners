<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use common\models\Forms;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $web_id
 * @property string $navn
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property string $department_id
 * @property string $id_avdelinger
 * @property string $tittel
 * @property int $inaktiv
 * @property string $mobiltelefon
 * @property string $urlstandardbilde
 * @property string $standardbildefil
 * @property int $inaktiv_status
 * @property string $role
 * @property string $url
 * @property string $short_name
 * @property int $status
 * @property int $theme_id
 * @property string $old_password
 * @property string $new_password
 * @property string $repeat_password
 *
 * Local Params
 * @property string $actingRole
 *
 * Relations
 * @property Department $department
 * @property Partner $partner
 * @property PropertyDetails[] $propertyDetails
 * @property string $password
 * @property string $authKey
 * @property string $image
 * @property Forms[] $leads
 * @property int $recruitdate
 * @property int $dismissaldate
 * @property Budsjett $budsjett
 * @property Theme $theme
 * @property int $basketCount
 */
class User extends ActiveRecord implements IdentityInterface
{

    const TEST_BROKER_ID = 777;// Broker for testing
    const TYPE_BROKER = 'broker';
    const TYPE_SUPER_ADMIN = 'superadmin';
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ACTING_DIRECTOR_ROLE = 'actingDirector';
    const SCENARIO_CHANGE_PASSWORD = "CHANGE_PASSWORD";

    public $image;
    public $actingRole;
    public $old_password;
    public $new_password;
    public $repeat_password;


    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [],
            self::SCENARIO_CHANGE_PASSWORD => ["old_password", "new_password", "repeat_password"],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['web_id', 'created_at', 'updated_at', 'department_id', 'id_avdelinger', 'inaktiv', 'inaktiv_status', 'status'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', ], 'required'],
            [['tittel', 'mobiltelefon', 'urlstandardbilde', 'standardbildefil', ], 'string'],
            [['navn', 'username', 'password_hash', 'password_reset_token', 'email', 'role', 'url', 'short_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['web_id'], 'unique'],
            [['old_password', 'new_password', 'repeat_password'], 'required',  'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['old_password', 'new_password', 'repeat_password'], 'string', 'min' => 6, "max" => 12, 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['old_password'], 'findPasswords', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['new_password'], 'compare', 'compareAttribute' => 'repeat_password', 'on' => self::SCENARIO_CHANGE_PASSWORD],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'web_id' => 'Web ID',
            'navn' => 'Navn',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'department_id' => 'Deprtment ID',
            'id_avdelinger' => 'Id Avdelinger',
            'tittel' => 'Tittel',
            'inaktiv' => 'Inaktiv',
            'mobiltelefon' => 'Mobiltelefon',
            'urlstandardbilde' => 'Urlstandardbilde',
            'standardbildefil' => 'Standardbildefil',
            'inaktiv_status' => 'Inaktiv Status',
            'role' => 'Role',
            'url' => 'Url',
            'short_name' => 'Short Name',
            'status' => 'Status',
            'old_password' => 'Gammelt passord',
            'new_password' => 'Nytt passord',
            'repeat_password' => 'Gjenta passord',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return User|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, "inaktiv_status" => -1]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return void the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     * @throws NotSupportedException
     */

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getUserImage()
    {
        return $this->urlstandardbilde;
    }

    public function getLeads()
    {
        return $this->hasMany(Forms::className(), ['delegated' => 'web_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['web_id' => 'id_avdelinger']);
    }

    /**
     * @return bool|int|string
     */
    public function getBasketCount()
    {
        return $this->hasOne(ShopBasket::class, ['user_id' => 'id'])->count('count');
    }

    /**
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::class, ['id' => 'partner_id'])
            ->viaTable(Department::tableName() . ' as dep', ['web_id' => 'id_avdelinger']);
    }

    public function getBudsjetts($year)
    {
        $budsjett = Budsjett::find()
            ->select([
                'SUM(befaringer) as befaringer',
                'SUM(salg) as salg',
                'SUM(inntekt) as inntekt'
            ])
            ->where(['IN', 'year', $year])
            ->andWhere(['user_id' => $this->web_id]);

        return $budsjett->asArray()->one();
    }


    public function getBudsjett()
    {
        return $this->hasOne(Budsjett::className(), ['user_id' => 'web_id']);
    }

    public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'image')) {
            $directory = Yii::getAlias('@frontend') . '/web/img/user/';
            $temp_name = $this->urlstandardbilde;
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }
            $this->urlstandardbilde = uniqid(time()) . '.' . $file->extension;
            $file->saveAs($directory . $this->urlstandardbilde);
            $this->urlstandardbilde=str_replace(Yii::$app->request->baseUrl,'',Url::base(true)).'/img/user/'.$this->urlstandardbilde;
            if ($this->id&&!empty($this->urlstandardbilde)){
                $temp_name = str_replace(Yii::$app->request->headers['origin'].'/img/user','',$temp_name);
                if (!is_dir($directory.$temp_name)&&file_exists($directory.$temp_name)) unlink($directory.$temp_name);
            }
        }
        return parent::beforeSave($insert);
    }

    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }

    /**
     * Get the signature for the user.
     *
     * @return string
     */
    public function getSignature(): string
    {
        return "<span>{$this->navn}</span><span>{$this->department->short_name}</span>";
    }

    public function getPropertyDetails()
    {
        return $this->hasMany(PropertyDetails::class, ['ansatte1_id' => 'web_id']);
    }

    public function getTheme()
    {
        return $this->hasOne(Theme::class, ['id' => 'theme_id']);
    }


    public function findPasswords($attribute, $params)
    {
        $user = self::findOne(["id" => Yii::$app->user->id]);
        $validatePassword = Yii::$app->security->validatePassword($this->old_password, $user->password_hash);
        if (!$validatePassword)
            $this->addError($attribute, 'Old password is incorrect.');
    }

}

