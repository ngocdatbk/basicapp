<?php

namespace app\helpers;

use Yii;

class ApiHelper
{
    private static $key = '8f2bfa483c3907e8b2b94cf41d1d711b';

    /**
     * Gen authenKey
     * @param mixed $params
     * @return authen = MD5(8f2bfa483c3907e8b2b94cf41d1d711b|||param1|||...)
     */
    public static function genAuthenKey($params)
    {
        if (!is_array($params)) {
            $params = [$params];
        }

        $keyword = implode('|||', $params);

        return md5(self::$key . '|||' . $keyword);
    }
}