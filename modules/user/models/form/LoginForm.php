<?php

namespace app\modules\user\models\form;

use app\helpers\ArrayHelper;
use app\modules\user\models\UserLoginAttempts;
use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;

class LoginForm extends \yii\base\Model
{

    public $email;
    public $password;
    public $rememberMe = true;
    public $rememberTime = 2592000; //3600 * 24 * 30
    private $_user = false;
    public $verifyCode;

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            [['rememberMe'], 'boolean'],
            // password is validated by validatePassword()
            [['email'], 'trim'],
            [['email'], 'email'],
            [['password'], 'validatePassword'],
            [['verifyCode'], 'captcha', 'skipOnEmpty' => YII_ENV_DEV],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user.global', 'Email'),
            'password' => Yii::t('user.global', 'Password'),
            'rememberMe' => Yii::t('user.global', 'Remember Me'),
            'verifyCode' => Yii::t('user.global', 'Verify Code'),
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

            if (!$user = $this->getUser()) {
                $this->addError($attribute, 'Incorrect email or password.');

                return false;
            }

            $userAuth = UserAuth::findOne($user->user_id);
            if (!$userAuth || !$userAuth->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');

                return false;
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $loginAttemptModel = new UserLoginAttempts();
        $numberLimit = ArrayHelper::getValue(Yii::$app->getModule('user')->params, 'number_login_attempt');

        if ($loginAttemptModel->countLoginAttempt($this->email) >= $numberLimit){
            Yii::$app->session->setFlash('error', Yii::t('user.field', 'Your account has been locked due to too many failed login'));
            return false;
        }

        if ($this->validate()) {
            if ($this->getUser()->is_active) {
                $loginAttemptModel->clearLoginAttempt($this->email);
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? $this->rememberTime : 0);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user.messagess', 'Your account is not active'));
            }
        }

        //add login attempt when login error
        $loginAttemptModel->logLoginAttempt($this->email);

        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

}
