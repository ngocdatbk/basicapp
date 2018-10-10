<?php

namespace app\helpers;

use Yii;
use yii\helpers\StringHelper as BaseStringHelper;

/**
 * Description of StringHelper
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class StringHelper extends BaseStringHelper
{

    /**
     * Get a part of paragraph (summary) in UTF-8 encode
     * @param String $content  source paragraph
     * @param Nummeric $charCount  number characters want to get
     * @return String  a part of paragraph with length equavalent $charCount.
     * @author ThaiDV
     */
    public static function subVNText($content, $charCount = 0, $overflow = '')
    {
        $pos = 0;

        if (mb_strlen($content, 'UTF-8') > $charCount) {
            $sentenceSymbol = array(".", "!", "?", " "); // điểm kết thúc câu
            $content = strip_tags($content, "<i></i>"); // những tag muốn giữ lại

            for ($i = $charCount; $i > 0; $i--) {
                $ch = mb_substr($content, $i, 1, 'UTF-8');

                if (in_array($ch, $sentenceSymbol)) {
                    $pos = $i;
                    $i = 0;
                }
            }

            $temp = mb_substr($content, 0, $pos = $pos > 0 ? $pos + 1 : $charCount, 'UTF-8');

            return $temp . $overflow;
        }

        return $content;
    }

    public static function isPhoneNumber($phoneNumber)
    {
        //remove all non numberic
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        //start with 0 --> 84
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '84' . substr($phoneNumber, 1);
        }

        if (preg_match("/^(841\d{9}|849\d{8}|84\d{8,10})$/", $phoneNumber)) {
            return true;
        }

        return false;
    }

    protected static $_randomData = '';
    protected static $_randomState;

    public static function generateRandomString($length, $raw = false)
    {
        $mixInternal = false;

        while (strlen(self::$_randomData) < $length) {
            if (function_exists('openssl_random_pseudo_bytes') && (substr(PHP_OS, 0, 3) != 'WIN' || version_compare(phpversion(), '5.3.4', '>='))
            ) {
                self::$_randomData .= openssl_random_pseudo_bytes($length);
                $mixInternal = true;
            } else if (function_exists('mcrypt_create_iv') && version_compare(phpversion(), '5.3.0', '>=')) {
                self::$_randomData .= mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
                $mixInternal = true;
            } else if (substr(PHP_OS, 0, 3) != 'WIN' && @file_exists('/dev/urandom') && @is_readable('/dev/urandom') && $fp = @fopen('/dev/urandom', 'r')
            ) {
                if (function_exists('stream_set_read_buffer')) {
                    stream_set_read_buffer($fp, 0);
                }

                self::$_randomData .= fread($fp, $length);
                fclose($fp);
                $mixInternal = true;
            } else {
                self::$_randomData .= self::generateInternalRandomValue();
            }
        }

        $return = substr(self::$_randomData, 0, $length);
        self::$_randomData = substr(self::$_randomData, $length);

        // have seen situations where duplicates may be read(!?!) so mix
        // in another source
        if ($mixInternal) {
            $final = '';
            foreach (str_split($return, 16) AS $i => $part) {
                $internal = uniqid(mt_rand());
                if ($i % 2 == 0) {
                    $final .= md5($part . $internal, true);
                } else {
                    $final .= md5($internal . $part, true);
                }
            }

            $return = substr($final, 0, $length);
        }

        if ($raw) {
            return $return;
        }

        // modified base64 to be more URL safe (roughly in rfc4648)
        return substr(strtr(base64_encode($return), array(
            '=' => '',
            "\r" => '',
            "\n" => '',
            '+' => '-',
            '/' => '_'
        )), 0, $length);
    }

    public static function generateInternalRandomValue() {
        if (!self::$_randomState) {
            self::$_randomState = md5(memory_get_usage() . getmypid()
            . serialize($_ENV) . serialize($_SERVER) . mt_rand() . microtime(), true);
        }

        $data = md5(uniqid(mt_rand(), true) . memory_get_usage() . microtime() . self::$_randomState, true);
        self::$_randomState = substr($data, 0, 8);

        return $data;
    }
    
    /**
     * Get base namespace of classname
     * app\modules\ModuleName\Module => app\module\ModuleName
     * @param string $className class with namespace
     * @return string
     */
    public static function getBaseNamespaceOfClass($className) {
        return substr($className, 0, strrpos($className, '\\'));
    }

    /**
     * Remove stop words and trim string
     * @param $string
     * @return string
     */
    public static function removeStopWord($string) {
        $stopWords = ArrayHelper::getValue(Yii::$app->getModule('crm')->params, 'stopWord');

        if(!empty($stopWords)) {
            foreach ($stopWords as $stopWord) {
                str_replace($stopWord, '', $string);
            }
        }

        return trim($string);
    }

    /**
     * Return the unmark Vietnamese
     * @param string $stringVN  Vietnamese with mark in utf8-charset
     * @return string had removed mark
     */
    public static function removeMarkInVn($stringVN, $replace = '-')
    {
        $markVN = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
        , "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
        , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
        , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
        , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", " ");

        $unMark = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
        , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
        , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
        , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
        , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "-");

        return str_replace('---', $replace, trim(preg_replace('/[^a-zA-Z0-9\-_]/', '', strtolower(str_replace($markVN, $unMark, $stringVN))), $replace));
    }

    /**
     * Remove all multiple whitespace from string
     * @param $string
     * @return null|string|string[]
     */
    public static function removeMultipleWhitespace($string)
    {
        return preg_replace('/\s+/', ' ', $string);
    }
}
