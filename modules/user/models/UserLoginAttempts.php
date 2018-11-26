<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_login_attempts".
 *
 * @property string $login
 * @property int $login_date
 */
class UserLoginAttempts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_login_attempts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'login_date'], 'required'],
            [['login_date'], 'integer'],
            [['login'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Login',
            'login_date' => 'Login Date',
        ];
    }

    /**
     *
     * @param type $usernameOrEmail
     * @return type
     */
    public static function logLoginAttempt($usernameOrEmail)
    {
        $loginAttempt = new static();
        $loginAttempt->setAttributes([
            'login' => $usernameOrEmail,
            'login_date' => time(),
        ]);

        return $loginAttempt->save();
    }

    /**
     *
     * @param type $usernameOrEmail
     * @return type
     */
    public static function countLoginAttempt($usernameOrEmail){
        return static::find()->where(['login' => $usernameOrEmail])->count();
    }

    /**
     *
     * @return type
     */
    public static function cleanLoginAttempt() {
        return static::deleteAll([
            '<=',
            'login_date',
            time() - ArrayHelper::getValue(Yii::$app->getModule('user')->params, 'time_retry_login', 0)
        ]);
    }

    /**
     *
     * @param type $usernameOrEmail
     * @return type
     */
    public static function clearLoginAttempt($usernameOrEmail){
        return static::deleteAll(['login' => $usernameOrEmail]);
    }
}
