<?php

namespace app\modules\user\models\form;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;

class ResetPassword extends \yii\base\Model
{
    public $password;
    public $password_repeat;

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('user.global', 'Password'),
            'password_repeat' => Yii::t('user.global', 'Password Repeat'),
        ];
    }

}
