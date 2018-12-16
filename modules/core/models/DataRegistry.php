<?php

namespace app\modules\core\models;

use Yii;

/**
 * This is the model class for table "data_registry".
 *
 * @property string $data_key
 * @property string $data_value
 */
class DataRegistry extends \app\components\Model
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_registry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_key', 'data_value'], 'required'],
            [['data_value'], 'string'],
            [['data_key'], 'string', 'max' => 25],
            [['data_key', 'data_value'], 'trim']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'data_key' => 'Data Key',
            'data_value' => 'Data Value',
        ];
    }

    /**
     * Gets the named item.
     * @param string $itemName
     * @return mixed|null Value of the entry or null if it couldn't be found
     */
    public function getItem($itemName)
    {
        $cacheItem = $this->_getCacheEntryName($itemName);
        $cache = Yii::$app->cache;
        $cacheData = ($cache ? $cache->get($cacheItem) : false);

        if ($cacheData !== false) {
            return unserialize($cacheData);
        }

        $data = $this->_getFromDb($itemName);

        if ($data !== false) {
            if ($cache) {
                $cache->set($cacheItem, $data, 86400);
            }

            return unserialize($data);
        }

        return null;
    }

    /**
     * Internal function to get the value of an item directly out of the DB,
     * ignoring the cache settings.
     *
     * @param string $itemName
     * @return string|false Serialized value or false if not found
     */
    protected function _getFromDb($itemName)
    {
        $model = static::findOne(['data_key' => $itemName]);

        if ($model === null) {
            return null;
        }

        return $model->data_value;
    }

    /**
     * Gets multiple entries from the registry at once.
     *
     * @param array $itemNames List of item names
     * @return array Format: [item name] => value, or null if it couldn't be found
     */
    public function getMulti(array $itemNames)
    {
        if (!$itemNames) {
            return [];
        }

        $cache = Yii::$app->cache;
        $dbItemNames = $itemNames;
        $data = array();

        foreach ($itemNames AS $k => $itemName) {
            $cacheData = ($cache ? $cache->get($this->_getCacheEntryName($itemName)) : false);
            if ($cacheData !== false) {
                $data[$itemName] = $cacheData;
                unset($dbItemNames[$k]);
            }
        }

        if ($dbItemNames) {
            $dbData = $this->_getMultiFromDb($dbItemNames);
            $data += $dbData;

            if ($cache) {
                foreach ($dbData AS $itemName => $dataValue) {
                    $cache->set($this->_getCacheEntryName($itemName), $dataValue);
                }
            }
        }

        foreach ($itemNames AS $itemName) {
            if (!isset($data[$itemName])) {
                $data[$itemName] = null;
            } else {
                $data[$itemName] = unserialize($data[$itemName]);
            }
        }

        return $data;
    }

    /**
     * Internal function to load multiple data registry values from the DB.
     *
     * @param array $itemNames
     *
     * @return array Format: [key] => value
     */
    protected function _getMultiFromDb(array $itemNames)
    {
        if (!$itemNames) {
            return array();
        }

        $data = static::find()->where([
            'data_key' => $itemNames,
        ])->all();

        return ArrayHelper::map($data, 'data_key', 'data_value');
    }

    /**
     * Sets a data registry value into the DB and updates the cache object.
     *
     * @param string $itemName
     * @param mixed $value
     */
    public function setItem($itemName, $value)
    {
        $serialized = serialize($value);
        $model = static::findOne(['data_key' => $itemName]);

        if ($model === null) {
            $model = new self;
            $model->data_key = $itemName;
        }

        $model->data_value = $serialized;
        $model->save();

        $cache = Yii::$app->cache;

        if ($cache) {
            $cache->set($this->_getCacheEntryName($itemName), $serialized);
        }
    }

    /**
     * Deletes a data registry value from the DB and cache.
     *
     * @param string $itemName
     */
    public function deleteItem($itemName)
    {
        static::deleteAll(['data_key' => $itemName]);

        $cache = Yii::$app->cache;

        if ($cache) {
            $cache->delete($this->_getCacheEntryName($itemName));
        }
    }

    /**
     * Gets the name that will be used in the cache for a given data
     * registry item.
     *
     * @param string $itemName Registry item name
     *
     * @return string Cache item name
     */
    protected function _getCacheEntryName($itemName)
    {
        return 'data_' . $itemName;
    }

}
