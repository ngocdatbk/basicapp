<?php

namespace app\helpers;

use Yii;
/**
 * Translate param array
 * @author TienNguyenXuan
 */
class LanguageTranslateHelper
{
    public static function translateParamArray($category, $message = [], $params = [], $language = null)
    {
        $p = [];
        foreach ((array) $message as $key => $value) {
            $p[$key] = Yii::t($category,$value,$params,$language);
        }
        return $p;
    }
}
