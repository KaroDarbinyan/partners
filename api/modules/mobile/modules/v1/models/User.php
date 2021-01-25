<?php

namespace api\modules\mobile\modules\v1\models;

use common\models\Forms;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;
use api\modules\mobile\modules\v1\models\query\UserQuery;

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
 * @property string $avdeling_id
 * @property string $tittel
 * @property int $inaktiv
 * @property string $mobiltelefon
 * @property string $urlstandardbilde
 * @property string $standardbildefil
 * @property int $inaktiv_status
 * @property string $role
 * @property string $url
 * @property string $short_name
 * @property string $allowed_deprtment
 * @property string $allowed_deprtment_title
 * @property int $status
 * @property string $password
 * @property string $authKey
 * @property string $access_token
 * @property string $expire_at
 * @property string $firebase_id
 */
class User extends ActiveRecord implements IdentityInterface
{

    public static $fields = [
        "id",
        "web_id",
        "navn",
        "username",
        "email",
        "department_id",
        "tittel",
        "mobiltelefon",
        "urlstandardbilde",
        "role",
        "url",
        "short_name",
        "firebase_id"
    ];


    public function fields()
    {
        return self::$fields;
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


    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public static function find()
    {
        return new UserQuery(get_called_class());
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
    public function getPropertyDetails()
    {
        return $this->hasMany(PropertyDetails::class, ["ansatte1_id" => "web_id"]);
    }

    /**
     * @return ActiveQuery
     */
    public function getForms()
    {
        return $this->hasMany(Forms::className(), ['broker_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDelegatedForms()
    {
        return $this->hasMany(Forms::className(), ['delegated' => 'web_id']);
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
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }


    public function getUserImage()
    {
        return $this->urlstandardbilde;
    }

    /**
     * Generate accessToken string
     * @return string
     * @throws Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = $this->access_token ?? Yii::$app->security->generateRandomString();
        return $this->access_token;
    }

    /**
     * {@inheritdoc}
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = static::find()->where(['access_token' => $token, 'status' => self::STATUS_ACTIVE])->one();
        if (!$user) {
            return false;
        }
        if ($user->expire_at < time()) {
            throw new UnauthorizedHttpException('the access - token expired ', -1);
        } else {
            return $user;
        }
    }


    /**
     * @return array
     * @throws Throwable
     */
    public function logout()
    {
        $this->updateAttributes(['access_token' => null, 'expire_at' => null]);
        try {
            $this->update(false);
        } catch (Throwable $e) {
            return ["message" => "abort operation"];
        }
        return ['message' => 'Successful operation'];
    }


    /**
     * for /api/mobile/v1/befaring/oppdrag/eiendomer
     * @return ActiveQuery
     */
    public function getPropertyDetailsForBefaring()
    {
        $query = $this->hasMany(PropertyDetails::class, ['ansatte1_id' => 'web_id'])
            ->select(["id", "CONCAT_WS(', ', `adresse`, `postnummer`, `poststed`) AS address", "lat", "lng"])
            ->with(['image', 'property'])->andWhere(['not', ['lat' => null, 'lng' => null]]);

        if (false) {
            $query = $query->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1,
                "property_details.tinde_oppdragstype" => "Til salgs",
            ])->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])->andWhere(['or',
                ['=', 'property_details.utlopsdato', 0],
                ['>', 'property_details.utlopsdato', time()]
            ]);
        }

        if (false && ($filter = Yii::$app->request->get("filter"))) {
            $query->andWhere(['>=', 'byggeaar', $filter['year'] - 1])
                ->andWhere(['or',
                    ['between', 'prom', $filter['meter'] - 10, $filter['meter'] + 10],
                    ['prom' => null]
                ])
                ->andWhere(['or',
                    ['between', 'salgssum', $filter['price'] - 500000, $filter['price'] + 500000],
                    ['salgssum' => null],
                    ['salgssum' => '']
                ])
                ->orWhere(['id' => Yii::$app->request->get('id')]);
        }

        return $query->asArray();
    }


}

