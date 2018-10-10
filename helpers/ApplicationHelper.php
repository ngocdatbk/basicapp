<?php

namespace app\helpers;

use app\helpers\CookieHelper;
use Yii;

/**
 * Application helper store all needed common helper may be used in application
 * @author LamNX <lamnguyenxuan@admicro.vn>
 */
class ApplicationHelper
{
    private static $_isCli = null;
    /**
     * Determine application run via command-line or via http
     * @return boolean
     */
    public static function isCLI()
    {
        return static::$_isCli !== null ? static::$_isCli : PHP_SAPI === 'cli';
    }

    public static function getModuleIds()
    {
        return array_keys(Yii::$app->modules);
    }

    public static function isHiddenSidebarMenu()
    {
        $showSideBar = CookieHelper::getCookie('hide_sidebar', false);
        if ($showSideBar === null) {
            return true;
        }

        return 1 == $showSideBar;
    }

}
