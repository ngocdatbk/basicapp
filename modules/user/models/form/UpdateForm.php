<?php

namespace app\modules\user\models\form;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

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
            [['fullname'], 'filter',
                'filter' => function ($value) {
                    return \yii\helpers\HtmlPurifier::process($value);
                }],

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

    public function updateUser()
    {
        if($this->validate())
        {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                if ($this->save()) {
                    //Update password if changed
                    if ($this->password) {
                        $userAuth = UserAuth::findOne(['user_id' => $this->user_id]);

                        if (!$userAuth) {
                            $userAuth = new UserAuth();
                            $userAuth->user_id = $this->user_id;
                            $userAuth->generateAuthKey();
                        }

                        $userAuth->setPassword($this->password);
                        if (!$userAuth->save()) {
                            $transaction->rollBack();
                            return null;

                        }
                    }
                    $transaction->commit();
                    return $this;
                }


            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return null;
    }

    protected function findModel($id)
    {
        if (($model = UpdateForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
