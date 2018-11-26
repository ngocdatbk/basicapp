<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_confirm".
 *
 * @property string $user_id
 * @property string $email
 * @property resource $confirm_key
 * @property string $created_at
 */
class UserConfirm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_confirm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'confirm_key', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['email'], 'string', 'max' => 150],
            [['confirm_key'], 'string', 'max' => 32],
            [['user_id'], 'unique'],
            [['confirm_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
            'confirm_key' => 'Confirm Key',
            'created_at' => 'Created At',
        ];
    }
}
