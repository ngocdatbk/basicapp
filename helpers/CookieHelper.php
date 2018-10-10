<?php

namespace app\helpers;

use Yii;

/**
 * Description of CookieHelper
 *
 * @author Admin
 */
class CookieHelper
{

    /**
     * Private constructor. Use statically.
     */
    private function __construct()
    {
        
    }

    /**
     * Internal helper to set or delete a cookie with Lnx-specific options.
     *
     * @param string $name Name of the cookie
     * @param string|false $value Value of the cookie, false to delete
     * @param integer $expiration Time stamp the cookie expires
     * @param boolean $httpOnly Whether the cookie should be available via HTTP only
     * @param boolean|null $secure Whether the cookie should be available via HTTPS only; if null, value is true if currently on HTTPS
     *
     * @return boolean True if set
     */
    protected static function _setCookieInternal($name, $value, $expiration = 0, $httpOnly = false, $secure = false)
    {
        if ($secure === null) {
            $secure = Yii::$app->secure;
        }

        if ($value === false) {
            $expiration = Yii::$app->time - 86400 * 365;
        }

        $cookieName = Yii::$app->params['cookieParams']['prefix'] . $name;

        try {
            $cookies = Yii::$app->response->cookies;

            $cookie = new \yii\web\Cookie([
                'name' => $cookieName,
                'value' => $value,
                'expire' => $expiration,
                'secure' => $secure,
                'httpOnly' => $httpOnly,
            ]);

            $cookies->add($cookie);
            return self::getCookie($name);
        } catch (Exception $e) {
            return false; // possibly an error with the name... silencing may not be ideal, but it shouldn't usually happen
        }
    }

    /**
     * Sets a cookie with Lnx-specific options.
     *
     * @param string $name Name of the cookie
     * @param string $value Value of the cookie
     * @param integer $lifetime The number of seconds the cookie should live from now. If 0, sets a session cookie.
     * @param boolean $httpOnly Whether the cookie should be available via HTTP only
     * @param boolean|null $secure Whether the cookie should be available via HTTPS only; if null, value is true if currently on HTTPS
     *
     * @return boolean True if set
     */
    public static function setCookie($name, $value, $lifetime = 0, $httpOnly = false, $secure = false)
    {
        $expiration = ($lifetime ? (Yii::$app->time + $lifetime) : 0);
        return self::_setCookieInternal($name, $value, $expiration, $httpOnly, $secure);
    }

    /**
     * Deletes the named cookie. The settings must match the settings when it was created.
     *
     * @param string $name Name of cookie
     * @param boolean $httpOnly Whether the cookie should be available via HTTP only
     * @param boolean|null $secure Whether the cookie should be available via HTTPS only; if null, value is true if currently on HTTPS
     *
     * @return boolean True if deleted
     */
    public static function deleteCookie($name, $httpOnly = false, $secure = null)
    {
        return self::_setCookieInternal($name, false, 0, $httpOnly, $secure);
    }

    /**
     * Deletes all cookies set by Lnx.
     *
     * @param array $skip List of cookies to skip
     * @param array $flags List of flags to apply to individual cookies. [cookie name] => {httpOnly: true/false, secure: true/false/null}
     */
    public static function deleteAllCookies(array $skip = array(), array $flags = array())
    {

        if (empty($_COOKIE)) {
            return;
        }

        if (empty($skip) && empty($flags)) {
            Yii::$app->request->cookies->removeAll();
            return;
        }

        $cookieParams = Yii::$app->params['cookieParams'];
        $prefix = $cookieParams['prefix'];

        foreach ($_COOKIE AS $cookie => $null) {
            if (strpos($cookie, $prefix) === 0) {
                $cookieStripped = substr($cookie, strlen($prefix));

                if (ArrayHelper::isIn($cookieStripped, $skip)) {
                    continue;
                }

                $cookieSettings = array('httpOnly' => false, 'secure' => null);

                if (!empty($flags[$cookieStripped])) {
                    $cookieSettings = ArrayHelper::merge($cookieSettings, $flags[$cookieStripped]);
                }

                self::_setCookieInternal($cookieStripped, false, 0, $cookieSettings['httpOnly'], $cookieSettings['secure']);
            }
        }
    }

    /**
     * Gets the specified cookie. This automatically adds the necessary prefix.
     *
     * @param string $name Cookie name without prefix
     * @return string|array|false False if cookie isn't found
     */
    public static function getCookie($name, $validation = true)
    {
        $cookieParams = Yii::$app->params['cookieParams'];
        $name = $cookieParams['prefix'] . $name;

        if ($validation === false) {
            if (isset($_COOKIE[$name])) {
                return $_COOKIE[$name];
            }

            return false;
        }

        return Yii::$app->request->cookies->getValue($name, false);
    }

    /**
     * Clears the specified ID from the specified cookie. The cookie must be a comma-separated ID list.
     *
     * @param integer|string $id
     * @param string $name
     *
     * @return array Exploded cookie array
     */
    public static function clearIdFromCookie($id, $cookieName)
    {
        $cookie = self::getCookie($cookieName);
        if (!is_string($cookie) || $cookie === '') {
            return array();
        }

        $cookie = explode(',', $cookie);
        $position = array_search($id, $cookie);

        if ($position !== false) {
            unset($cookie[$position]);
            self::setCookie($cookieName, implode(',', $cookie));
        }

        return $cookie;
    }
}