<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_auth".
 *
 * @property string $user_id
 * @property string $auth_key
 * @property string $password_hash
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'auth_key', 'password_hash'], 'required'],
            [['user_id'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 60],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'password_hash' => 'Password Hash',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password
     *            password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Delete user auth
     * @param $userId
     * @return bool|false|int
     * @throws \Exception
     * @throws \Throwable
     */
    public static function deleteUserAuth($userId) {
        $userAuth = static::findOne($userId);

        if($userAuth === null) {
            return true;
        }

        return $userAuth->delete();
    }
}
