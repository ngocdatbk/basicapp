<?php
/**
 * Description of CronHelper
 *
 * @author LinhDM
 */

namespace app\modules\cronjob\helpers;

use Yii;
use DateTime;

class CronHelper
{
    /**
     * Calculate the next run time for an entry using the given rules. Rules expected in keys:
     *    minutes, hours, dow, dom (all arrays) and day_type (string: dow or dom)
     * Array rules are in format: -1 means "any", any other value means on those specific
     * occurances. DoW runs 0 (Sunday) to 6 (Saturday).
     *
     * @param array $runRules Run rules. See above for format.
     * @param integer|null $currentTime Current timestamp; null to use current time from application
     *
     * @return integer Next run timestamp
     */
    public static function calculateNextRunTime(array $runRules, $currentTime = null)
    {
        $currentTime = ($currentTime === null ? time() : $currentTime);

        $nextRun = new DateTime('@' . $currentTime);
        $nextRun->modify('+1 minute');

        if (empty($runRules['minutes'])) {
            $runRules['minutes'] = array(-1);
        }
        self::_modifyRunTimeMinutes($runRules['minutes'], $nextRun);

        if (empty($runRules['hours'])) {
            $runRules['hours'] = array(-1);
        }
        self::_modifyRunTimeHours($runRules['hours'], $nextRun);

        if (!empty($runRules['day_type'])) {
            if ($runRules['day_type'] == 'dow') {
                if (empty($runRules['dow'])) {
                    $runRules['dow'] = array(-1);
                }
                self::_modifyRunTimeDayOfWeek($runRules['dow'], $nextRun);
            } else {
                if (empty($runRules['dom'])) {
                    $runRules['dom'] = array(-1);
                }
                self::_modifyRunTimeDayOfMonth($runRules['dom'], $nextRun);
            }
        }

        return intval($nextRun->format('U'));
    }

    /**
     * Modifies the next run time based on the minute rules.
     *
     * @param array $minuteRules Rules about what minutes are valid (-1, or any number of values 0-59)
     * @param DateTime $nextRun Date calculation object. This will be modified.
     */
    protected static function _modifyRunTimeMinutes(array $minuteRules, DateTime &$nextRun)
    {
        $currentMinute = $nextRun->format('i');
        self::_modifyRunTimeUnits($minuteRules, $nextRun, $currentMinute, 'minute', 'hour');
    }

    /**
     * Modifies the next run time based on the hour rules.
     *
     * @param array $hourRules Rules about what hours are valid (-1, or any number of values 0-23)
     * @param DateTime $nextRun Date calculation object. This will be modified.
     */
    protected static function _modifyRunTimeHours(array $hourRules, DateTime &$nextRun)
    {
        $currentHour = $nextRun->format('G');
        self::_modifyRunTimeUnits($hourRules, $nextRun, $currentHour, 'hour', 'day');
    }

    /**
     * Modifies the next run time based on the day of month rules. Note that if
     * the required DoM doesn't exist (eg, Feb 30), it will be rolled over as if
     * it did (eg, to Mar 2).
     *
     * @param array $hourRules Rules about what days are valid (-1, or any number of values 0-31)
     * @param DateTime $nextRun Date calculation object. This will be modified.
     */
    protected static function _modifyRunTimeDayOfMonth(array $dayRules, DateTime &$nextRun)
    {
        $currentDay = $nextRun->format('j');
        self::_modifyRunTimeUnits($dayRules, $nextRun, $currentDay, 'day', 'month');
    }

    /**
     * Modifies the next run time based on the day of week rules.
     *
     * @param array $hourRules Rules about what days are valid (-1, or any number of values 0-6 [sunday to saturday])
     * @param DateTime $nextRun Date calculation object. This will be modified.
     */
    protected static function _modifyRunTimeDayOfWeek(array $dayRules, DateTime &$nextRun)
    {
        $currentDay = $nextRun->format('w'); // 0 = sunday, 6 = saturday
        self::_modifyRunTimeUnits($dayRules, $nextRun, $currentDay, 'day', 'week');
    }

    /**
     * General purpose run time calculator for a set of rules.
     *
     * @param array $unitRules List of rules for unit. Array of ints, values -1 to unit-defined max.
     * @param DateTime $nextRun Date calculation object. This will be modified.
     * @param integer $currentUnitValue The current value for the specified unit type
     * @param string $unitName Name of the current unit (eg, minute, hour, day, etc)
     * @param string $rolloverUnitName Name of the unit to use when rolling over; one unit bigger (eg, minutes to hours)
     */
    protected static function _modifyRunTimeUnits(array $unitRules, DateTime &$nextRun, $currentUnitValue, $unitName, $rolloverUnitName)
    {
        if (sizeof($unitRules) && reset($unitRules) == -1) {
            // correct already
            return;
        }

        $currentUnitValue = intval($currentUnitValue);
        $rollover = null;

        sort($unitRules, SORT_NUMERIC);
        foreach ($unitRules AS $unitValue) {
            if ($unitValue == -1 || $unitValue == $currentUnitValue) {
                // already in correct position
                $rollover = null;
                break;
            } else if ($unitValue > $currentUnitValue) {
                // found unit later in date, adjust to time
                $nextRun->modify('+ ' . ($unitValue - $currentUnitValue) . " $unitName");
                $rollover = null;
                break;
            } else if ($rollover == null) {
                // found unit earlier in the date; use smallest value
                $rollover = $unitValue;
            }
        }

        if ($rollover !== null) {
            $nextRun->modify(($rollover - $currentUnitValue) . " $unitName");
            $nextRun->modify("+ 1 $rolloverUnitName");
        }
    }
}
