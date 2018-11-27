<?php

namespace app\modules\user\models\form;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;

class SignupForm extends \yii\base\Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $fullname;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat'], 'required'],
            [['email'], 'filter', 'filter' => 'trim'],
            [['email'], 'string', 'max' => 120],
            [['email'], 'email'],
            [['email'], 'unique',
                'targetClass' => '\app\modules\user\models\User',
                'message' => 'This user has already been taken.'],
            [['password'], 'string', 'min' => 6],
            [['password_repeat'], 'string', 'min' => 6],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['fullname'], 'string', 'max' => 150],
            [['verifyCode'], 'captcha']
        ];
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user.auth', 'Email'),
            'password' => Yii::t('user.auth', 'Password'),
            'password_repeat' => Yii::t('user.auth', 'Password repeat'),
            'fullname' => Yii::t('user.auth', 'Full name'),
            'verifyCode' => Yii::t('user.auth', 'Verification Code')
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $user = new User();
                $user->username = $this->email;
                $user->email = $this->email;
                $user->fullname = $this->fullname;
                $user->is_active = 1;

                if ($user->save()) {
                    $userAuth = new UserAuth();
                    $userAuth->user_id = $user->user_id;
                    $userAuth->setPassword($this->password);
                    $userAuth->generateAuthKey();

                    if ($userAuth->save()) {
                        $transaction->commit();
                        return $user;
                    }
                }

                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return null;
    }
}
