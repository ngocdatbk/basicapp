<?php

namespace app\helpers;

use Yii;
use yii\helpers\BaseUrl;

/**
 * UrlHelper
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class UrlHelper
{

    public static function exportDomainFromUrl($url, &$isSsl = false)
    {
        $domain = parse_url($url, PHP_URL_HOST);

        foreach (Yii::$app->params['exceptCNAME'] as $cname) {
            if (strpos($domain, "$cname.") === 0) {
                $domain = preg_replace("/$cname\./", '', $domain, 1);
                break;
            }
        }

        $protocol = parse_url($url, PHP_URL_SCHEME);
        $isSsl = $protocol == 'http' ? 0 : 1;

        return $domain;
    }

    public static function exportUrlScheme($url, &$isSsl = false)
    {
        $parts = parse_url($url);

        if (empty($parts) || empty($parts['host'])) {
            $isSsl = 0;
            return null;
        }

        $domain = $parts['host'] . (empty($parts['path']) ? '' : $parts['path']) . (empty($parts['query']) ? '' : ('?' . $parts['query']));

        $domain = trim($domain, "/ \t\r\0\x0B");

        foreach (Yii::$app->params['exceptCNAME'] as $cname) {
            if (strpos($domain, "$cname.") === 0) {
                $domain = preg_replace("/$cname\./", '', $domain, 1);
                break;
            }
        }

        $isSsl = (!empty($parts['scheme']) && $parts['scheme'] == 'http') ? 0 : 1;

        return $domain;
    }

    public static function getUrlRefererForList($default, $entity = 'account')
    {
        $currUrl = $entity . '_' . md5(parse_url(Yii::$app->request->url, PHP_URL_QUERY));
        $prevUrl = unserialize(CookieHelper::getCookie($currUrl));
        if (empty($prevUrl)) {
            $referer = Yii::$app->request->referrer;
            if ($referer) {
                parse_str(parse_url($referer, PHP_URL_QUERY));

                if (!empty($page)) {
                    $prevUrl = $referer;
                    CookieHelper::setCookie($currUrl, serialize($referer), 900);
                }
            }
        }

        return empty($prevUrl) ? $default : $prevUrl;
    }
    
    public static function getAbsoluteUrl($url)
    {
        if (BaseUrl::isRelative($url)) {
            return '//' . $url;
        }
        
        return BaseUrl::ensureScheme($url, '');
    }
    
    /**
     * return domain of an url
     * @param string $url
     * @return string
     */
    public static function getDomain($url)
    {
        if (parse_url($url, PHP_URL_HOST)) {
            $url = parse_url($url, PHP_URL_HOST);
        }
        
        if ($pos = strpos($url, '/')) {
            $url = substr($url, 0, $pos);
        }
        
        return str_replace('www.', '', $url);
    }

}