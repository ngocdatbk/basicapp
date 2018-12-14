<?php

namespace app\modules\core\models;

use app\helpers\ArrayHelper;
use app\helpers\Php;
use app\modules\permission\models\Permission;
use Yii;
use yii\helpers\Html;
use app\components\Model;

/**
 * This is the model class for table "admin_navigation".
 *
 * @property resource $navigation_id
 * @property string $label
 * @property string $icon
 * @property string $url
 * @property resource $menu_group
 * @property string $parent_id
 * @property string $level
 * @property resource $label_type
 * @property resource $permission_type
 * @property string $permission
 * @property integer $debug_only
 * @property string $display_order
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property integer $display_f
 */
class AdminNavigation extends Model
{
    public $display_before;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_navigation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['display_before'], 'safe'],
            [['navigation_id', 'label'], 'required'],
            [['level', 'debug_only', 'display_order', 'created_date', 'created_by', 'updated_date', 'updated_by', 'display_f'], 'integer'],
            [['navigation_id', 'menu_group', 'label_type', 'permission_type', 'parent_id', 'display_before'], 'string', 'max' => 30],
            [['label', 'permission'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 150],
            [['parent_id'], 'default', 'value' => 0],
            [['permission'], 'validateCallBack'],
            [['label'], 'validateLabel'],
            [['parent_id'], 'validateParent'],
            [['label', 'permission', 'icon', 'url'], 'trim'],
            [['url', 'label', 'permission', 'icon'], 'filter',
                'filter' => function ($value) {
                    return \yii\helpers\HtmlPurifier::process($value);
                }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'navigation_id' => Yii::t('core.admin_menu', 'Navigation ID'),
            'label' => Yii::t('core.admin_menu', 'Label'),
            'icon' => Yii::t('core.admin_menu', 'Icon'),
            'url' => Yii::t('core.admin_menu', 'Url'),
            'menu_group' => Yii::t('core.admin_menu', 'Group'),
            'parent_id' => Yii::t('core.admin_menu', 'Parent ID'),
            'level' => Yii::t('core.admin_menu', 'Level'),
            'label_type' => Yii::t('core.admin_menu', 'Label Type'),
            'permission_type' => Yii::t('core.admin_menu', 'Permission Type'),
            'permission' => Yii::t('core.admin_menu', 'Permission'),
            'debug_only' => Yii::t('core.admin_menu', 'Debug Only'),
            'display_order' => Yii::t('core.admin_menu', 'Display Order'),
            'created_date' => Yii::t('core.admin_menu', 'Created Date'),
            'created_by' => Yii::t('core.admin_menu', 'Created By'),
            'updated_date' => Yii::t('core.admin_menu', 'Updated Date'),
            'updated_by' => Yii::t('core.admin_menu', 'Updated By'),
            'display_f' => Yii::t('core.admin_menu', 'Display F'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
            $this->created_date = time();
        } else {
            $this->updated_by = Yii::$app->user->id;
            $this->updated_date = time();
        }

        if ($this->parent_id) {
            $parentLevel = static::findOne(['navigation_id' => $this->parent_id])->level;
            $this->level = $parentLevel + 1;
        } else {
            $this->level = 0;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
//        if (Yii::$app->cache && (!defined('YII_DEBUG') || (defined('YII_DEBUG') && !YII_DEBUG))) {
            Yii::$app->cache->set('menu_' . $this->menu_group, $this->_getMenuItems($this->menu_group));
//        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * Validate callback class and callback method
     *
     * @param $attribute
     * @param $params
     *
     * @return bool
     */
    public function validateCallBack($attribute, $params)
    {
        if ($this->permission_type == 'callback') {
            if (empty($this->permission)) {
                $this->addError($attribute, $this->{$attribute} . ' required');

                return false;
            }

            if (strpos($this->permission, '::') == false) {
                $this->addError($attribute, $this->{$attribute} . ' is not format');

                return false;
            }

            list($callbackClass, $callbackMethod) = explode('::', $this->permission);

            if (!Php::validateCallback($callbackClass, $callbackMethod)) {

                $this->addError($attribute, 'Class or method has invalid');

                return false;
            }

            return true;
        }

        return true;
    }

    /**
     * Validate callback class and callback method
     *
     * @param $attribute
     * @param $params
     *
     * @return bool
     */
    public function validateLabel($attribute, $params)
    {
        if ($this->label_type == 'callback') {

            if (!strpos($this->label, '::')) {
                $this->addError($attribute, $this->{$attribute} . ' is not format Class::Method');

                return false;
            }

            list($class, $method) = explode('::', $this->label);

            if (!Php::validateCallback($class, $method)) {

                $this->addError($attribute, 'Class or method has invalid');

                return false;
            }

            return true;
        }

        return true;
    }

    public function validateParent($attribute, $params){

        if ($this->parent_id) {

            $listChildItems = static::find()->select('navigation_id')->where(['parent_id' => $this->parent_id])->asArray()->all();

            if (in_array($this->parent_id, $listChildItems)) {
                $this->addError($attribute, 'You can\'t not select this parent item');

                return false;
            }

            if ($this->parent_id == $this->navigation_id) {
                $this->addError($attribute, 'Parent menu can not is self or child of menu');

                return false;
            }

            $parentNavigation = static::findOne(['navigation_id' => $this->parent_id]);
            
            if ($parentNavigation->menu_group != $this->menu_group) {
                $this->addError($attribute, 'Not exist item in this group');

                return false;
            }

            return true;
        }
    }

    /**
     * Check exists class name
     *
     * @param string $className
     *
     * @return bool
     */
    protected function _classExists($className)
    {
        return class_exists($className) && in_array($className, get_declared_classes());
    }

    /**
     * Get parent menu
     *
     * @return \yii\db\ActiveQuery parent menu
     */
    public function getParentMenu()
    {
        return $this->hasOne(static::className(), ['navigation_id' => 'parent_id']);
    }

    /**
     * Get permission
     *
     * @return \yii\db\ActiveQuery Permission
     */
    public function getPermissionItems()
    {
        return $this->hasOne(Permission::className(), ['permission_id' => 'permission']);
    }

    public function getChildrenMenu ()
    {
        return $this->hasMany(static::className(), ['parent_id' => 'navigation_id']);
    }

    public function getAdminMenuChilds($parent_id, $currentId = '')
    {
        $parent_id = $parent_id ? $parent_id : '0';
        $query = static::find()->select('navigation_id, label, label_type, level')
            ->select(['navigation_id', 'CONCAT (\' position \',display_order, \' - \', label) as label'])
            ->where(['AND', ['display_f' => 1], ['parent_id' => $parent_id]]);
        if ($currentId) {
            $query->andWhere(['<>', 'navigation_id', $currentId]);
        }

        $listItems = $query->orderBy(['display_order' => SORT_ASC, 'created_date' => SORT_ASC])->all();
        if (!empty($listItems)) {
            return ArrayHelper::mapToIndex($listItems, ['id' => 'navigation_id', 'text' => 'label']);
        }

        return [];
    }

    public function getAdminMenuOptions($q, $group, $except = [])
    {
        $roots = array('navigation_id' => 'root', 'label' => 'root', 'children' => array(), 'rule_name' => '');
        $query = static::find()->where(['AND', ['display_f' => 1], ['menu_group' => $group]]);
        if (!empty($q)) {
            $query->andWhere(['LIKE', 'label', $q]);
        }
        $menuItems = $query->orderBy(['display_order' => SORT_ASC, 'created_date' => SORT_ASC])->indexBy('navigation_id')->asArray()->all();

        $menuItems['root'] = $roots;

        foreach ($menuItems as $id => $menuItem) {
            if (!isset($menuItem['parent_id']))
                continue;
            $parent_id = $menuItem['parent_id'] ? $menuItem['parent_id'] : 'root';
            if (!isset($menuItems[$parent_id]['children']))
                $menuItems[$parent_id]['children'] = array();
            $menuItems[$parent_id]['children'][$id] = $menuItem;
        }

        $except['root'] = 'root';
        $result = [];
        $this->buildTree($result,'', $menuItems, $menuItems['root'], $except);
        return $result;
    }

    public function buildTree(&$result, $pre, $listChilds, $root, $except)
    {
        if (!isset($except[$root['navigation_id']])) {
            $result[] = ['id' => $root['navigation_id'], 'text' => $pre.$root['label']];
        }

        if (isset($root['children'])) {
            $childs = $root['children'];
            foreach ($childs as $name => $child) {
                if (isset($except[$name]))
                    continue;
                $this->buildTree($result, '----'.$pre, $listChilds, $listChilds[$name], $except);
            }
        }
    }

    /**
     * Get label admin menu by level
     *
     * @return string label
     */
    public function getTitleByLevel()
    {
        if ($this->label_type == 'callback') {
            return str_repeat('&nbsp;', $this->level * 6) . call_user_func($this->label);
        }

        return str_repeat('&nbsp;', $this->level * 6) . Html::encode($this->label);
    }

    /**
     * Get label by label type
     *
     * @param $labelType
     * @param $label
     *
     * @return mixed
     */
    public function getLabel($labelType, $label)
    {
        if ($labelType == 'callback') {

            return call_user_func($label);
        }

        return $label;
    }

    /**
     * Get list menu Items
     *
     * @param $group
     *
     * @return mixed|static[]
     */
    public function getMenuItems($group)
    {

        $isDebug = defined('YII_DEBUG') && (YII_DEBUG == true);

        if (Yii::$app->cache && !$isDebug) {
            if (($menuItems = Yii::$app->cache->get('menu_' . $group)) === false) {
                $menuItems = $this->_getMenuItems($group);
                Yii::$app->cache->set('menu_' . $group, $menuItems);
            }

            return $this->prepareMenuItems($menuItems);
        }

        return $this->prepareMenuItems($this->_getMenuItems($group));
    }

    /**
     *
     * @param $group
     *
     * @return static[]
     */
    protected function _getMenuItems($group)
    {
        $condition = [
            'display_f' => 1,
            'menu_group' => $group,
        ];

        if (!defined('YII_DEBUG') || (defined('YII_DEBUG') && !YII_DEBUG)) {
            $condition['debug_only'] = 0;
        }

        return static::find()->where($condition)->orderBy(['display_order' => SORT_ASC, 'created_date' => SORT_ASC])->asArray()->all();
    }

    /**
     * prepare Items
     *
     * @param array $items
     *
     * @return \app\helpers\type|array
     */
    public function prepareMenuItems(array $items)
    {
        $menuItems = [];

        foreach ($items as $item) {
            $menuItems[$item['navigation_id']] = $this->_renderMenuItem($item);
        }

        return ArrayHelper::buildHierarchyArray($menuItems);
    }

    /**
     * @param $item
     *
     * @return array
     */
    public function _renderMenuItem($item)
    {
        $menuItem = [
            'parent_id' => $item['parent_id'],
            'id' => $item['navigation_id'],
            'label' => $this->getLabel($item['label_type'], $item['label']),
        ];

        //Heading sidebar menu item
        if (empty($item['url'])) {
            $menuItem['url'] = false;
            $menuItem['icon'] = $item['icon'];

            return $menuItem;
        }

        $menuItem['url'] = [$item['url']];
        $menuItem['icon'] = $item['icon'];
        $menuItem['options'] = ['class' => 'navTab'];

        if (!empty($item['permission_type'])) {
            $menuItem['visible'] = $this->checkPermission($item);
        }

        return $menuItem;
    }

    public static $cachedCallbackClass = [];

    /**
     * Check permission menu item
     *
     * @param $item
     *
     * @return bool
     *
     */
    protected function checkPermission($item)
    {
        if ($item['permission_type'] == 'admin') {
            return Yii::$app->user->isAdmin;
        }

        if ($item['permission_type'] == 'permission') {
            return Yii::$app->user->can($item['permission']);
        }

        if ($item['permission_type'] == 'callback' && strpos($item['permission'], '::') !== false) {

            list($callbackClass, $callbackMethod) = explode('::', $item['permission']);

            if (!isset(static::$cachedCallbackClass[$callbackClass]) && class_exists($callbackClass)) {
                static::$cachedCallbackClass[$callbackClass] = new $callbackClass;
            }

            $callback = isset(static::$cachedCallbackClass[$callbackClass]) && is_object(static::$cachedCallbackClass[$callbackClass]) ? static::$cachedCallbackClass[$callbackClass] : null;

            return $callback !== null ? call_user_func([$callback, $callbackMethod]) : false;
        }

        return false;
    }


    public function filterFields()
    {
        $fields = $this->toArray();

        unset(
            $fields['navigation_id'],
            $fields['permission_type'],
            $fields['permission'],
            $fields['debug_only'],
            $fields['display_order'],
            $fields['created_date'],
            $fields['created_by'],
            $fields['updated_date'],
            $fields['updated_by']
        );

        $fields['id'] = $this->navigation_id;
        $fields['titleByLevel'] = $this->label_type == 'callback' ?
            str_repeat('&nbsp;', $this->level * 6) . call_user_func($this->label) :
            str_repeat('&nbsp;', $this->level * 6) . Html::encode($this->label);

        return $fields;
    }

    public static function buildMenuItems($menuItems)
    {
        $rebuildItems = [];

        foreach ($menuItems as $item) {
            $rebuildItems[$item->navigation_id] = $item->filterFields();
        }

        return ArrayHelper::buildHierarchyArray($rebuildItems);
    }
}
