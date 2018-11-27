<?php

namespace app\modules\user\models\form;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuthConfirm;
use yii\helpers\Url;

class ForgotPasswordForm extends \yii\db\ActiveRecord
{

    public $email;
    public $verifyCode;

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 100],
            [['verifyCode'], 'captcha'],
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
            'confirm_key' => Yii::t('user.global', 'Confirm key'),
            'verifyCode' => Yii::t('user.auth', 'Verification Code'),
        ];
    }

}
