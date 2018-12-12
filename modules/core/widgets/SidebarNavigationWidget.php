<?php

namespace app\modules\core\widgets;

use app\helpers\ArrayHelper;
use app\modules\core\models\AdminNavigation;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Nav;
use yii\helpers\Html;

class SidebarNavigationWidget extends Nav
{
    public $items;

    /*
     * Default icon
     * */
    public $defaultIcon = 'fa-circle-o'; //set default icon

    /*
     * Default Url
     */
    public $defaultUrl = '#'; //set default url

    /**
     * @inheritdoc
     */
    public $encodeLabels = false;

    /**
     * @inheritdoc
     */
    public $options = ['class' => ['widget' => 'sidebar-menu']];


    /**
     * @inheritdoc
     */
    public $activateParents = true;

    /**
     * @inheritdoc
     */
    public $dropDownCaret = '<i class="fa pull-right pull-right-container fa-angle-left"></i>';

    /**
     * If set true, item will be added automatically data-toggle = dropdown
     *
     * @var type
     */
    public $dropDownMenu = false;

    public function run ()
    {
        $this->items = $this->prepareItemsBeforeRender(AdminNavigation::getInstance()->getMenuItems('sidebar_menu'));

        return parent::run();
    }

    /**
     * Add options style of adminLTE menu
     *
     * @param array $items
     *
     * @return array|null
     * @throws InvalidConfigException
     */
    public function prepareItemsBeforeRender ($items = null)
    {
        if ($items === null) {
            $items = $this->items;
        }

        foreach ($items as $key => &$item) {
            if (is_string($item)) {
                $item = Html::tag('li', $item, ['class' => 'header']);
                continue;
            }

            if (!isset($item['label'])) {
                throw new InvalidConfigException("The 'label' option is required.");
            }

            if (isset($item['icon'])) {
                $item['icon'] = $item['icon'];
            } else {
                $item['icon'] = $this->defaultIcon;
            }

            if ($item['icon'] !== false) {
                $item['label'] = '<i class="fa ' . $item['icon'] . '"></i> <span class="title">' . $item['label'] . '</span>';
            }

            $item['linkOptions'] = isset($item['linkOptions']) ? ArrayHelper::merge($item['linkOptions'],
                ['class' => ['widget' => '']]) : ['class' => ['widget' => '']];

            if (isset($item['items']) && !empty($item['items'])) {
                $item['options'] = isset($item['options']) ? ArrayHelper::merge($item['options'],
                    ['class' => ['widget' => 'treeview']]) : ['class' => ['widget' => 'treeview']];

                $item['dropDownOptions'] = isset($item['dropDownOptions']) ? ArrayHelper::merge($item['dropDownOptions'],
                    ['class' => ['widget' => 'treeview-menu']]) : ['class' => ['widget' => 'treeview-menu']];

                $item['items'] = $this->prepareItemsBeforeRender($item['items']);
            }
        }

        return $items;
    }

    /**
     * @inheritdoc
     */
    protected function isItemActive ($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }

            $route = ltrim($route, '/') . '/';
            if (substr($this->route . '/', 0, strlen($route)) !== $route) {
                return false;
            }

            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function renderItem ($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', $this->defaultUrl);
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $items = '';
        } else {
            Html::addCssClass($options, ['widget' => 'dropdown']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        if ($url === false) {
            $options['class'] = 'header';

            return Html::tag('li', $label . $items, $options);
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

}