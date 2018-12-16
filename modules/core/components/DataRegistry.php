<?php

namespace app\modules\core\components;

use app\modules\core\models\DataRegistry as DataRegistryModel;

/**
 * DataRegistry
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class DataRegistry extends \yii\base\Component
{

    public function get($itemName)
    {
        return (new DataRegistryModel)->getItem($itemName);
    }

    public function getMulti(array $itemNames)
    {
        return (new DataRegistryModel)->getMulti($itemNames);
    }

    public function set($itemName, $value)
    {
        return (new DataRegistryModel)->setItem($itemName, $value);
    }

    public function delete($itemName)
    {
        return (new DataRegistryModel)->deleteItem($itemName);
    }

}
