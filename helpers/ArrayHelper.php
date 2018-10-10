<?php

namespace app\helpers;

use yii\helpers\ArrayHelper as YiiArrayHelper;

/**
 * Extend of \yii\helpers\ArrayHelper
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class ArrayHelper extends YiiArrayHelper
{

    /**
     * Rebuild map to new index
     * ```php
     * $array = [
     *      ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
     *      ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
     *      ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
     * ];
     * 
     * $result = ArrayHelper::mapToIndex($array, ['new_id' => 'id', 'new_name' => 'name']);
     * 
     * // the result is:
     * // [
     * //     ['new_id' => 123, 'new_name' => 'aaa'],
     * //     ['new_id' => 124, 'new_name' => 'bbb'],
     * //     ['new_id' => 345, 'new_name' => 'ccc'],
     * // ]
     * ```
     * @param array $array
     * @param array $keymap
     * @return array
     */
    public static function mapToIndex($array, $keymap, $group = null)
    {
        $result = [];

        foreach ($array as $index => $element) {
            foreach ($keymap as $newkey => $field) {

                if ($group !== null) {
                    $result[static::getValue($element, $group)][$newkey] = static::getValue($element, $field);
                } else {
                    $result[$index][$newkey] = static::getValue($element, $field);
                }
            }
        }

        return $result;
    }

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    static function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }

    /**
     * Build hierarchy nodes
     * @param array $nodes
     * @param type $parentId
     * @param type $depth
     * @return type
     */
    public static function buildHierarchyArray(array $items, $idField = 'id', $parentField = 'parent_id', $parentId = 0, $depth = 0)
    {
        $hierarchyItems = [];

        if ($depth == 0) {
            $items = static::getArrayHierarchy($items, $idField, $parentField);
        }

        if (empty($items[$parentId])) {
            return [];
        }

        foreach ($items[$parentId] as $item) {
            if (!empty($items[$item[$idField]])) {
                $item['items'] = static::buildHierarchyArray($items, $idField, $parentField, $item[$idField], $depth+1);
            }

            $hierarchyItems[$item[$idField]] = $item;
        }

        return $hierarchyItems;
    }

    /**
     * Gets an array representing the node hierarchy that can be traversed recursively
     * Format: item[parent_id][node_id] = node
     *
     * @param array|null Node list
     *
     * @return array Node hierarchy
     */
    public static function getArrayHierarchy($items, $idField = 'id', $parentField = 'parent_id')
    {
        $hierarchyItems = [];

        foreach ($items as $item) {
            $hierarchyItems[$item[$parentField]][$item[$idField]] = $item;
        }

        return $hierarchyItems;
    }

    /**
     * Writes a value into an associative array at the key path specified.
     * If there is no such key path yet, it will be created recursively.
     * If the key exists, it will be overwritten.
     *
     * ```php
     *  $array = [
     *      'key' => [
     *          'in' => [
     *              'val1',
     *              'key' => 'val'
     *          ]
     *      ]
     *  ];
     * ```
     *
     * The result of `ArrayHelper::setValue($array, 'key.in.0', ['arr' => 'val']);` will be the following:
     *
     * ```php
     *  [
     *      'key' => [
     *          'in' => [
     *              ['arr' => 'val'],
     *              'key' => 'val'
     *          ]
     *      ]
     *  ]
     *
     * ```
     *
     * The result of
     * `ArrayHelper::setValue($array, 'key.in', ['arr' => 'val']);` or
     * `ArrayHelper::setValue($array, ['key', 'in'], ['arr' => 'val']);`
     * will be the following:
     *
     * ```php
     *  [
     *      'key' => [
     *          'in' => [
     *              'arr' => 'val'
     *          ]
     *      ]
     *  ]
     * ```
     *
     * @param array $array the array to write the value to
     * @param string|array|null $path the path of where do you want to write a value to `$array`
     * the path can be described by a string when each key should be separated by a dot
     * you can also describe the path as an array of keys
     * if the path is null then `$array` will be assigned the `$value`
     * @param mixed $value the value to be written
     * @since 2.0.13
     */
    public static function setValue(&$array, $path, $value)
    {
        if ($path === null) {
            $array = $value;
            return;
        }

        $keys = is_array($path) ? $path : explode('.', $path);

        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key])) {
                $array[$key] = [];
            }
            if (!is_array($array[$key])) {
                $array[$key] = [$array[$key]];
            }
            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;
    }
}
