<?php

namespace app\modules\permission\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    public function listPermissionTree($for, $except = [])
    {
        $authItems = $this->find()
            ->select(['name','description'])
            ->where(['type' => 2])
            ->asArray()
            ->indexBy('name')
            ->asArray()
            ->all();
        $authItemParents = AuthItemChild::find()
            ->innerJoin(AuthItem::tableName(),'auth_item.name = auth_item_child.parent')
            ->select(['parent','child'])
            ->where(['type' => 2])
            ->indexBy('child')
            ->asArray()
            ->column();

        $permissions = $authItems;
        foreach ($authItemParents as $child => $parent) {
            if (!isset($permissions[$parent]['children']))
                $permissions[$parent]['children'] = array();
            $permissions[$parent]['children'][$child] = $authItems[$child];
            $permissions[$child]['parent'] = $authItems[$parent];
        }

        $roots = array('name' => 'root', 'description' => '', 'children' => array());
        foreach ($permissions as $name => $permission) {
            if (!isset($permission['parent']))
                $roots['children'][$name] = $permission;
        }
        $permissions['root'] = $roots;

        $except['root'] = 'root';
        return $this->buildTree('', $permissions, $permissions['root'], $for, $except);
    }

    public function buildTree($pre, $listChilds, $root, $for, $except)
    {
        $result = [];
        if (!isset($except[$root['name']])) {
            if ($for == 'input')
                $result[$root['name']] = $pre.$root['description'];
            else
                $result[$root['name']] = array('name' => $root['name'], 'description' => $pre.$root['description']);
        }

        if (isset($root['children'])) {
            $childs = $root['children'];
            foreach ($childs as $name => $child) {
                if (isset($except[$name]))
                    continue;
                $result = array_merge($result, $this->buildTree('----'.$pre, $listChilds, $listChilds[$name], $for, $except));
            }
        }

        return $result;
    }

    public function listPermissionWithAssigned()
    {
        $listAllPermission = $this->listPermissionTree('list');
        $listAssignedPermission = AuthItemChild::find()
            ->innerJoin(AuthItem::tableName(),'auth_item.name = auth_item_child.child')
            ->select(['parent','child'])
            ->where(['type' => 2, 'parent' => $this->name])
            ->indexBy('child')
            ->asArray()
            ->column();

        foreach ($listAssignedPermission as $name => $assignedPermission) {
            $listAllPermission[$name]['allow'] = true;
        }
        return $listAllPermission;
    }
}
