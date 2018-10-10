<?php

namespace app\helpers;

use Yii;
use Carbon\Carbon;
use DateTime as DateTime2;
use DateTimeZone;
use Faker\Provider\zh_TW\DateTime;
use yii\db\Exception;

/**
 * Handle date and time
 * @author LamNX <lamnguyenxuan@admicro.vn>
 */
class AppLocale
{

    /**
     * Default language to use for locale-specific output (if not overridden).
     *
     * @var array
     */
    protected static $_language = array();

    /**
     * Default time zone to use for locale-specific output (if not overridden)
     *
     * @var DateTimeZone|null
     */
    protected static $_timeZone = NULL;

    /**
     * A cached DateTime object. This will be set only if setTimestamp exists on it
     * (PHP 5.3 and newer). This serves as an optimization to avoid object creation
     * and date parsing overhead.
     *
     * @var DateTime|null
     */
    protected static $_dateObj = null;
    protected static $_dayStartTimestamps = null;

    /**
     * Translate a numeric day of the week to representation that will be used in phrases.
     *
     * @var array
     */
    protected static $_dowTranslation = array(
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday'
    );

    /**
     * Sets the default time zone.
     *
     * @param string|DateTimeZone $timeZoneString String time zone (eg, Europe/London);
     */
    public static function setDefaultTimeZone($timeZoneString)
    {
        if (!$timeZoneString) {
            return;
        }

        if ($timeZoneString instanceof DateTimeZone) {
            self::$_timeZone = $timeZoneString;
        } else {
            try {
                self::$_timeZone = new DateTimeZone($timeZoneString);
            } catch (Exception $e) {
                return;
            }
        }

        if (method_exists('DateTime', 'setTimestamp')) {
            self::$_dateObj = new DateTime2('', self::$_timeZone);
        }
    }

    /**
     * Formats the given timestamp as a date.
     *
     * @param integer|DateTime $timestamp Unix timestamp or a DateTime object that's already configured
     * @param string $format Format that maps to a known type. Uses default if specified. (Currently ignored.)
     * @param string|DateTimeZone|null $timeZoneString String time zone to override default
     *
     * @return string
     */
    public static function date($timestamp, $format = null, $timeZoneString = NULL)
    {
        if ($timestamp === null || $timestamp === false || $timestamp === 0) {
            return '';
        }

        $timestamp = ($timestamp = intval($timestamp)) < 0 ? 0 : $timestamp;

        if ($timeZoneString === null) {
            $timeZoneString = Yii::$app->timeZone;
        }

        $date = self::_getDateObject($timestamp, $timeZoneString);
        $rtlPrefix = self::getRtlDateTimeMarker();

        switch ($format) {
            case 'year':
                $dateFormat = 'Y';
                break;

            case 'monthDay':
                $dateFormat = 'F j';
                break;

            case 'picker':
                $dateFormat = 'Y-m-d';
                $rtlPrefix = '';
                break;

            case 'absolute':
            case 'relative':
            case '':
                $dateFormat = (isset(Yii::$app->params['date_format']) ? Yii::$app->params['date_format'] : 'M j, Y');
                break;

            default:
                $dateFormat = $format;
                $rtlPrefix = '';
        }

        if (empty(Yii::$app->params['date_format'])) {
            return $rtlPrefix . $date->format($dateFormat);
        } else {
            if (!$format || $format == 'relative') {
                $relativeDate = self::getRelativeDate($date);

                if ($relativeDate !== false) {
                    return $rtlPrefix . $relativeDate;
                }
            }

            return $rtlPrefix . self::getFormattedDateInternal($date, $dateFormat);
        }
    }

    /**
     * Gets a date object that fits the requirements (correct timestamp and time zone).
     *
     * @param integer|DateTime|null $timestamp Unix timestamp or a DateTime object that's already configured
     * @param string|DateTimeZone|null $timeZoneString String time zone. If null, uses default (and can use date object optimization if available)
     *
     * @return DateTime
     */
    protected static function _getDateObject($timestamp = null, $timeZoneString = null)
    {
        if ($timestamp instanceof DateTime) {
            return $timestamp;
        } else if ($timestamp === null) {
            $timestamp = Yii::$app->time;
        }

        if ($timeZoneString) {
            if ($timeZoneString instanceof DateTimeZone) {
                $timeZone = $timeZoneString;
            } else {
                $timeZone = new DateTimeZone($timeZoneString);
            }
        } else {
            if (!self::$_timeZone) {
                self::setDefaultTimeZone('UTC');
            }

            if (self::$_dateObj) {
                self::$_dateObj->setTimestamp($timestamp);

                return self::$_dateObj;
            }

            $timeZone = self::$_timeZone;
        }

        $dt = new DateTime2('@' . $timestamp);
        $dt->setTimezone($timeZone);
        return $dt;
    }

    /**
     * Fetches timestamps for the start of today, yesterday or a week ago
     *
     * @return array [now => long, today => long, todayDow => long, yesterday => long, week => long]
     */
    public static function getDayStartTimestamps()
    {
        if (!self::$_dayStartTimestamps) {
            $date = new DateTime2('@' . Yii::$app->time);
            $date->setTimezone(self::$_timeZone ? self::$_timeZone : new DateTimeZone('UTC'));
            $date->setTime(0, 0, 0);

            list($todayStamp, $todayDow) = explode('|', $date->format('U|w'));

            $date->modify('-1 day');
            $yesterdayStamp = $date->format('U');

            $date->modify('-5 days');
            $weekStamp = $date->format('U');

            self::$_dayStartTimestamps = array(
                'now' => Yii::$app->time,
                'today' => $todayStamp,
                'todayDow' => $todayDow,
                'yesterday' => $yesterdayStamp,
                'week' => $weekStamp
            );
        }

        return self::$_dayStartTimestamps;
    }

    public static function getRtlDateTimeMarker()
    {
        if (!empty(Yii::$app->params['text_direction']) && Yii::$app->params['text_direction'] == 'RTL') {
            return "\xE2\x80\x8F"; // right to left marker
        } else {
            return '';
        }
    }

    /**
     * Formats the given timestamp as a date and a time.
     *
     * @param integer|DateTime $timestamp Unix timestamp or a DateTime object that's already configured
     * @param string $format Format that maps to a known type. Uses default if specified.
     * @param string|DateTimeZone|null $timeZoneString String time zone to override default
     *
     * @return string|array If format 'separate' is specified, returns [dateString, date, time]
     */
    public static function dateTime($timestamp, $format = null, $timeZoneString = null)
    {
        if (empty($timeZoneString)) {
            $timeZoneString = Yii::$app->timeZone;
        }

        $date = self::_getDateObject($timestamp, $timeZoneString);
        $rtlPrefix = self::getRtlDateTimeMarker();

        if (empty(Yii::$app->params['time_format'])) {
            return $rtlPrefix . $date->format('M j, Y g:i A');
        } else {
            if (!$format || $format == 'relative') {
                $relativeDate = self::getRelativeDateTime($date, Yii::$app->params['time_format']);

                if ($relativeDate !== false) {
                    return $rtlPrefix . $relativeDate;
                } else {
                    return $rtlPrefix . self::getFormattedDateInternal($date, Yii::$app->params['time_format'] . ', ' . Yii::$app->params['date_format']);
                }
            }

            switch ($format) {
                case 'absolute':
                case 'separate':
                default:
                    $dateTimeFormat = Yii::$app->params['date_format'] . '|' . Yii::$app->params['time_format'];
                    $formatPhrase = 'date_x_at_time_y';
            }

            $parts = explode('|', self::getFormattedDateInternal($date, $dateTimeFormat));

            $dateFind = array(
                'date' => $parts[0],
                'time' => $parts[1]
            );

            $dateString = Yii::t('app.time', $formatPhrase, $dateFind);

            if ($format == 'separate') {
                $dayStarts = self::getDayStartTimestamps();

                return array(
                    'string' => $dateString,
                    'date' => $parts[0],
                    'time' => $parts[1],
                    'relative' => ($timestamp > $dayStarts['week'])
                );
            } else {
                return $rtlPrefix . $dateString;
            }
        }
    }

    /**
     * Returns a string representing the given date and time as a relative period before now, in certain circumstances
     *
     * @param DateTime $date
     * @param string $timeFormat
     *
     * @return string|false
     */
    public static function getRelativeDateTime(DateTime2 $date, $timeFormat)
    {
        $timestamp = $date->format('U');
        $interval = Yii::$app->time - $timestamp;

        if ($interval < 0) {
            //TODO: handle future dates - Tomorrow, later today...
            return false;
        }

        if ($interval <= 60) {
            return Yii::t('app.time', 'a_moment_ago');
        }

        if ($interval < 120) {
            return Yii::t('app.time', 'one_minute_ago');
        }

        if ($interval < 3600) {
//            return str_replace(
//            'minutes', floor($interval / 60), 'x_minutes_ago'
//            );
            return Yii::t('app.time', 'x_minutes_ago', ['minutes' => floor($interval / 60)]);
        }

        $dayStartTimestamps = self::getDayStartTimestamps();

        if ($timestamp >= $dayStartTimestamps['today']) {
            return Yii::t('app.time', 'today_at_x', ['time' => self::getFormattedDateInternal($date, $timeFormat)]);
        }

        if ($timestamp >= $dayStartTimestamps['yesterday']) {
            return Yii::t('app.time', 'yesterday_at_x', ['time' => self::getFormattedDateInternal($date, $timeFormat)]);
        }

        if ($timestamp >= $dayStartTimestamps['week']) {
            $dateReplace = explode('|', self::getFormattedDateInternal($date, 'l|' . $timeFormat));

            $dateFind = array(
                'day' => $dateReplace[0],
                'time' => $dateReplace[1]
            );

            return Yii::t('app.time', 'day_x_at_time_y', $dateFind);
        }

        return false;
    }

    /**
     * Returns a string representing the given date as today, yesterday, dayname (within this past week)
     *
     * @param DateTime $date
     * @param string $timeFormat
     *
     * @return string|false
     */
    public static function getRelativeDate(DateTime2 $date)
    {
        $timestamp = $date->format('U');

        if ($timestamp > Yii::$app->time) {
            // TODO: date in the future... Tomorrow, Later today
            return false;
        }

        $dayStartTimestamps = self::getDayStartTimestamps();

        if ($timestamp >= $dayStartTimestamps['today']) {
            return Yii::t('app.time', 'today');
        }

        if ($timestamp >= $dayStartTimestamps['yesterday']) {
            return Yii::t('app.time', 'yesterday');
        }

        if ($timestamp >= $dayStartTimestamps['week']) {
            return self::getFormattedDateInternal($date, 'l');
        }

        return false;
    }

    /**
     * Gets the formatted date/time using the given format. String-based
     * identifiers (months, days of week) need to be passed in.
     *
     * @param DateTime $date DateTime object, with correct time set
     * @param string $format Format to display as; supports a subset of the formats from the built-in date() function
     *
     * @return string Formatted date
     */
    public static function getFormattedDateInternal(DateTime2 $date, $format)
    {
        $dateParts = explode('|', $date->format('j|w|W|n|Y|G|i|s|S'));
        list($dayOfMonth, $dayOfWeek, $weekOfYear, $month, $year, $hour, $minute, $second, $ordinalSuffix) = $dateParts;

        $output = '';

        $formatters = str_split($format);
        $formatterCount = count($formatters);

        for ($i = 0; $i < $formatterCount; $i++) {
            $identifier = $formatters[$i];

            switch ($identifier) {
                // day of month
                case 'd':
                    $output .= sprintf('%02d', $dayOfMonth);
                    continue;
                case 'j':
                    $output .= $dayOfMonth;
                    continue;

                // day of week
                case 'D':
                    $output .= Yii::t('app.time', ('day_' . self::$_dowTranslation[$dayOfWeek] . '_short'));
                    continue;
                case 'l':
                    $output .= Yii::t('app.time', ('day_' . self::$_dowTranslation[$dayOfWeek]));
                    continue;

                // week
                case 'W':
                    $output .= $weekOfYear;
                    continue;

                // month
                case 'm':
                    $output .= sprintf('%02d', $month);
                    continue;
                case 'n':
                    $output .= $month;
                    continue;
                case 'F':
                    $output .= Yii::t('app.time', ('month_' . $month));
                    continue;
                case 'M':
                    $output .= Yii::t('app.time', ('month_' . $month . '_short'));
                    continue;

                // year
                case 'Y':
                    $output .= $year;
                    continue;
                case 'y':
                    $output .= substr($year, 2);
                    continue;

                // am/pm
                case 'a':
                    $output .= Yii::t('app.time', ($hour >= 12 ? 'time_pm_lower' : 'time_am_lower'));
                    continue;
                case 'A':
                    $output .= Yii::t('app.time', ($hour >= 12 ? 'time_pm_upper' : 'time_am_upper'));
                    continue;

                // hour
                case 'H':
                    $output .= sprintf('%02d', $hour);
                    continue;
                case 'h':
                    $output .= sprintf('%02d', $hour % 12 ? $hour % 12 : 12);
                    continue;
                case 'G':
                    $output .= $hour;
                    continue;
                case 'g':
                    $output .= ($hour % 12 ? $hour % 12 : 12);
                    continue;

                // minute
                case 'i':
                    $output .= $minute;
                    continue;

                // second
                case 's':
                    $output .= $second;
                    continue;

                // ordinal
                case 'S':
                    $output .= $ordinalSuffix;
                    continue;

                case '\\':
                    $i++;
                    if ($i < $formatterCount) {
                        $output .= $formatters[$i];
                    }
                    continue;

                // anything else is printed
                default:
                    $output .= $identifier;
            }
        }

        return $output;
    }

    /**
     * Get time of date or today
     * @param date|string $date if date = today, get time of today
     */
    public static function getTimeOfDate($date = 'today', $format = 'd/m/Y')
    {
        if ($date == 'today') {
            return strtotime(date('d-m-Y'));
        }

        return strtotime(Carbon::createFromFormat($format, $date)->toDateString());
    }

    /**
     * Get time of date or today
     * @param date|string $date if date = today, get time of today
     */
    public static function getTimeOfDateTime($date = 'today', $format = 'H:i:s d/m/Y')
    {
        if ($date == 'today') {
            return strtotime(date('H:i:s d-m-Y'));
        }

        return strtotime(Carbon::createFromFormat($format, $date)->toDateTimeString());
    }

    public static function getFirstDayOfMonth($format = 'd-m-Y')
    {
        return self::date(strtotime(date('00:00:00 1-m-Y')), $format);
    }

    public static function getLastDayOfMonth($format = 'd-m-Y')
    {
        return self::date(strtotime(date('00:00:00 t-m-Y')), $format);
    }

    /**
     * Get start date of current week
     * @param string $format
     * @return string
     */
    public static function getStartDateOfCurrentWeek($format = 'd/m/Y')
    {
        $carbon = Carbon::createFromTimestamp(Yii::$app->time);
        $carbon->startOfWeek();

        return $carbon->format($format);
    }

    /**
     * Get end date of current week
     * @param string $format
     * @return string
     */
    public static function getEndDateOfCurrentWeek($format = 'd/m/Y')
    {
        $carbon = Carbon::createFromTimestamp(Yii::$app->time);
        $carbon->endOfWeek();

        return $carbon->format($format);
    }

    /**
     * Get start date of a week of year
     * @param string $week
     * @param string $year
     * @param string $format
     * @return string
     */
    public static function getStartDateOfWeek($week, $year, $format = 'd/m/Y')
    {
        $carbon = Carbon::createFromDate($year, 1, 1);
        $carbon->startOfWeek();
        $carbon->addWeek($week);

        return $carbon->format($format);
    }

    /**
     * Get start date of a week of year
     * @param string $week
     * @param string $year
     * @param string $format
     * @return string
     */
    public static function getEndDateOfWeek($week, $year, $format = 'd/m/Y')
    {
        $carbon = Carbon::createFromDate($year, 1, 1);
        $carbon->startOfWeek();
        $carbon->addWeek($week);
        $carbon->endOfWeek();

        return $carbon->format($format);
    }

    /**
     * Get start date of current month
     * @param string $format
     * @return string
     */
    public static function getStartDateOfCurrentMonth($format = 'd/m/Y')
    {
        $carbon = Carbon::createFromTimestamp(Yii::$app->time);
        $carbon->startOfMonth();

        return $carbon->format($format);
    }

    /**
     * Get end date of current month
     * @param string $format
     * @return string
     */
    public static function getEndDateOfCurrentMonth($format = 'd/m/Y')
    {
        $carbon = Carbon::createFromTimestamp(Yii::$app->time);
        $carbon->endOfMonth();

        return $carbon->format($format);
    }

    /**
     * Get end date of a month
     * @param $month
     * @param $year
     * @param string $format
     * @return string
     */
    public static function getEndDateOfMonth($month, $year, $format = 'd/m/Y')
    {
        $carbon = Carbon::createFromDate($year, $month, 1);
        $carbon->endOfMonth();

        return $carbon->format($format);
    }

    public function isValidDate($attribute)
    {
        if ($this->$attribute && preg_match('#^([0-9]{1,2}+\/[0-9]{1,2}+\/[0-9]{4}$)#', $this->$attribute)) {
            list($day, $mon, $year) = explode('/', $this->$attribute);

            if (CTimestamp::isValidDate($year, $mon, $day)) {
                $this->$attribute = CTimestamp::getTimestamp(0, 0, 0, $mon, $day, $year);
            } else {
                $this->addError($attribute, $this->getAttributeLabel($attribute) . ' không đúng');
            }
        } elseif ($this->isNewRecord) {
            $this->$attribute = Application::$time;
        }
    }

    /**
     * Get first time of a month
     * @param integer $month
     * @param integer $year
     * @return timestamp|false
     */
    public static function getFirstTimeOfMonth($month = false, $year = false)
    {
        static::_prepareForGetLastTime($month, $year);

        $date = new \Carbon\Carbon("first day of $month $year");

        if ($date) {
            return $date->getTimestamp();
        }

        return false;
    }

    /**
     * Get last time of a month
     * @param integer $month
     * @param integer $year
     * @return timestamp|false
     */
    public static function getLastTimeOfMonth($month = false, $year = false)
    {
        static::_prepareForGetLastTime($month, $year);

        $date = new \Carbon\Carbon("last day of $month $year");

        if ($date) {
            return strtotime($date->format('23:59:59 d-m-Y'));
        }

        return false;
    }

    protected static function _prepareForGetLastTime(&$month, &$year)
    {
        if ($month == false) {
            $month = date('F');
        } else {
            $month = intval($month);
            $dateObj = \DateTime::createFromFormat('!m', $month);
            $month = $dateObj->format('F');
        }

        if ($year == false) {
            $year = date('Y');
        }
    }

}
