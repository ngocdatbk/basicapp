<?php

namespace app\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $username
 * @property string $gender
 * @property string $email
 * @property string $phone_number
 * @property string $fullname
 * @property int $is_active
 * @property int $is_admin
 * @property string $last_login
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    private $_userAuth = false;

    const USER_INACTIVE = 0;
    const USER_ACTIVE = 1;
    const USER_NOT_VERIFY = 2;
    const USER_WAITING_VERIFY = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'fullname', 'username'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => '\app\modules\user\models\User'],
            [['email'], 'string', 'max' => 120],
            ['username', 'unique',
                'targetClass' => '\app\modules\user\models\User',
                'message' => 'This username has already been taken.'],
            [['username'], 'string', 'max' => 32],
            ['username', 'match', 'pattern' => '/^[a-z0-9_]\w*$/'],
            [['fullname'], 'string', 'max' => 150],
            [['is_active', 'is_admin'], 'integer'],
            ['last_login', 'integer'],
            [['email', 'username', 'fullname'], 'trim'],
            [['fullname'], 'filter',
                'filter' => function ($value) {
                    return \yii\helpers\HtmlPurifier::process($value);
                }],

            [['gender'], 'string'],
            [['phone_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'gender' => 'Gender',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'fullname' => 'Fullname',
            'user_type' => 'User Type',
            'is_active' => 'Is Active',
            'is_admin' => 'Is Admin',
            'last_login' => 'Last Login',
        ];
    }

    /**
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findOneWithPermission($user_id)
    {
        return static::find()
//            ->with('permissionRoleUser')
            ->where(['user_id' => $user_id])
            ->one();
    }
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $loggedUserId = Yii::$app->session->get('loggedUserId');

        if ($loggedUserId && $viewAsData = Yii::$app->dataRegistry->get('viewAsUser')) {
            if (isset($viewAsData[$loggedUserId]['viewAsUserId']) && $id == $loggedUserId) {
                $id = $viewAsData[$loggedUserId]['viewAsUserId'];
            }
        }

        return static::findOneWithPermission($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        $userAuth = $this->_getUserAuth();

        if ($userAuth === null) {
            throw new NotSupportedException('"getAuthKey" is not implemented.');
        }

        return $userAuth->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        $transaction = static::getDb()->beginTransaction();

        try {
            $result = parent::delete();

            if ($result === false || !UserAuth::deleteUserAuth($this->user_id)) {
                $transaction->rollBack();
                $result = false;
            } else {
//                UserCaution::deleteAll(['user_id' => $this->user_id]);
//                UserExternal::deleteAll(['user_id' => $this->user_id]);
                $transaction->commit();
            }

            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function afterDelete()
    {
        // Delete permission role user
//        PermissionRoleUser::deleteAll(['user_id' => $this->user_id]);

        parent::afterDelete();
    }

    /**
     * @return UserAuth|null
     */
    private function _getUserAuth()
    {
        if ($this->_userAuth === false) {
            $this->_userAuth = UserAuth::findOne(['user_id' => $this->user_id]);
        }

        return $this->_userAuth;
    }

    public static function getMapping()
    {
        $users = static::find()->all();

        if ($users) {
            return ArrayHelper::map($users, 'user_id', 'fullname');
        }

        return [];
    }
}
