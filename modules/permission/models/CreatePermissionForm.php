<?php

namespace app\modules\permission\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\modules\permission\models\AuthItemChild;
use yii\rbac\Item;

class CreatePermissionForm extends AuthItem
{
    public $parent;

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
            [['parent'], 'string'],
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
            'parent' => Yii::t('permission.permission', 'Parent'),
        ];
        return ArrayHelper::merge($attributeLabels, $attributeLabels_extend);
    }

    public function createPermission()
    {
        $this->type = Item::TYPE_PERMISSION;
        $this->created_at = time();
        $this->updated_at = time();
        if ($this->validate()) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $this->save();
                if ($this->parent) {
                    $authItemChild = new AuthItemChild();
                    $authItemChild->parent = $this->parent;
                    $authItemChild->child = $this->name;
                    $authItemChild->save();
                }
                $transaction->commit();
                return $this;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return null;
            }
        }

        return null;
    }
}
