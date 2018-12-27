<?php

namespace app\modules\user\models\form;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;
use yii\helpers\ArrayHelper;
use app\modules\permission\models\AuthAssignment;

class CreateForm extends User
{
    public $password;
    public $password_repeat;

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
        $rules = parent::rules();
        $rules_extend = [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
        ];
        return ArrayHelper::merge($rules, $rules_extend);
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
            'password_repeat' => Yii::t('user.global', 'Password repeat')
        ];
        return ArrayHelper::merge($attributeLabels, $attributeLabels_extend);
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $this->save();

                $userAuth = new UserAuth();
                $userAuth->user_id = $this->user_id;
                $userAuth->setPassword($this->password);
                $userAuth->generateAuthKey();
                $userAuth->generateAccessToken();
                $userAuth->save();

                if ($this->roles) {
                    $rows = [];
                    foreach ($this->roles as $rid => $role) {
                        $rows[] = ['item_name' => $role, 'user_id' => $this->user_id, 'created_at' => time()];
                    }
                    Yii::$app->db->createCommand()->batchInsert(AuthAssignment::tableName(), ['item_name', 'user_id', 'created_at'], $rows)->execute();
                }

                $transaction->commit();
                return $this;
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }

        return null;
    }

}
