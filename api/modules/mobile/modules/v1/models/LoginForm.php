<?php

namespace api\modules\mobile\modules\v1\models;

use Throwable;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Login form
 *
 * @property null|User $user
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    Const EXPIRE_TIME = 604800; // 7 day
    /**
     * @var User|null
     */
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError("message", "Incorrect username or password.");
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool|array whether the user is logged in successfully
     * @throws Exception
     * @throws Throwable
     */
    public function auth()
    {
        if ($this->validate() && $this->getUser()) {
            $access_token = $this->_user->generateAccessToken();
            $this->_user->expire_at = time() + static::EXPIRE_TIME;
            $this->_user->update();
            return [
                "expire_at" => $this->_user->expire_at,
                "access_token" => $access_token,
                "redirect_url" => Url::toRoute(["eiendom/index"]),
            ];
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
