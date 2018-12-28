<?php

namespace app\modules\user\models\form;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\modules\permission\models\AuthAssignment;

class UpdateForm extends User
{
    public $password;

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
            [['roles'], 'safe'],
            [['password'], 'string', 'min' => 6],
            [['email', 'username', 'fullname'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique',
                'targetClass' => '\app\modules\user\models\User',
                'filter' => ['!=', 'user_id', $this->user_id],
                'message' => 'This user has already been taken.'
            ],
            [['email'], 'string', 'max' => 120],
            ['username', 'unique',
                'targetClass' => '\app\modules\user\models\User',
                'filter' => ['!=', 'user_id', $this->user_id],
                'message' => 'This username has already been taken.'
            ],
            [['username'], 'string', 'max' => 32],
//            ['username', 'match', 'pattern' => '/^[a-z0-9_]\w*$/'],
            [['fullname'], 'string', 'max' => 150],
            [['is_active', 'is_admin'], 'integer'],
            ['last_login', 'integer'],
            [['email', 'username', 'fullname'], 'trim'],
            [['fullname'], 'filter', 'filter' => function ($value) { return \yii\helpers\HtmlPurifier::process($value);}],
            [['gender'], 'string'],
            [['phone_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels_extend = [
            'password' => Yii::t('user.global', 'Password'),
        ];
        return ArrayHelper::merge($attributeLabels, $attributeLabels_extend);
    }

    public function updateUser($old_roles)
    {
        if($this->validate())
        {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $this->save();
                if ($this->password) {
                    $userAuth = UserAuth::findOne(['user_id' => $this->user_id]);

                    if (!$userAuth) {
                        $userAuth = new UserAuth();
                        $userAuth->user_id = $this->user_id;
                        $userAuth->generateAuthKey();
                    }

                    $userAuth->setPassword($this->password);
                    $userAuth->save();
                }

                $new_roles = $this->roles;

                $insert_roles = array_diff($new_roles, $old_roles);
                $delete_roles = array_diff($old_roles, $new_roles);

                if ($insert_roles) {
                    $rows = [];
                    foreach ($insert_roles as $rid => $role) {
                        $rows[] = ['item_name' => $role, 'user_id' => $this->user_id, 'created_at' => time()];
                    }
                    Yii::$app->db->createCommand()->batchInsert(AuthAssignment::tableName(), ['item_name', 'user_id', 'created_at'], $rows)->execute();
                }
                if ($delete_roles)
                    AuthAssignment::deleteAll(['user_id' => $this->user_id, 'item_name' => $delete_roles]);

                $transaction->commit();
                return $this;
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }

        return null;
    }

    public static function findModel($id)
    {
        if (($model = UpdateForm::findOne($id)) !== null) {
            $model->roles = AuthAssignment::find()->where(['user_id' => $model->user_id])->column();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
