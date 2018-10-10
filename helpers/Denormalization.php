<?php

namespace app\helpers;

use yii\db\ActiveRecord as ActiveRecord;

/**
 * Provide functions to validate serialize data and list integer value (ex: 1,2,3)
 * @author LamNX <lamnguyenxuan@admicro.vn>
 */
class Denormalization
{
    public static function verifyIntCommaList(&$list, ActiveRecord $model, $fieldName = false)
    {
        if ($list === '') {
            return true;
        }

        $items = explode(',', $list);
        $items = array_map('intval', $items);
        $listNew = implode(',', $items);
        if ($list === $listNew) {
            return true;
        }

        // debugging message, no need for phrasing
        $model->addError($fieldName, 'Please provide a list of values separated by commas only.');
        return false;
    }

    public static function verifySerialized(&$serial, ActiveRecord $model, $fieldName = false)
    {
        if (!is_string($serial)) {
            $serial = serialize($serial);
            return true;
        }

        if (@unserialize($serial) === false && $serial != serialize(false)) {
            // debugging message, no need for phrasing
            $model->addError($fieldName, 'The data provided as a serialized array does not unserialize.');
            return false;
        }

        return true;
    }
}
