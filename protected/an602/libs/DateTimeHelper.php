<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\libs;

use DateTime;
use Yii;

/**
 * DateTimeHelper
 *
 * @author Luke
 */
class DateTimeHelper
{

    /**
     * Rounds given DateTime object to the next full hour
     * 
     * @param DateTime $dateTime
     * @return DateTime
     */
    public static function roundToNextFullHour(DateTime $dateTime = null)
    {
        if ($dateTime === null) {
            $dateTime = new DateTime();
        }

        $minutes = $dateTime->format('i');

        $dateTime->modify("+1 hour");

        if ($minutes > 0) {
            $dateTime->modify('-' . $minutes . ' minutes');
        }

        return $dateTime;
    }

    public static function getTimeFormat()
    {
        return Yii::$app->formatter->isShowMeridiem() ? 'h:mm a' : 'php:H:i';
    }

    /**
     * Converts two given DateTime instances or strings into a DateInterval
     * 
     * @param DateTime|string|null $startDateTime the start date or null for current date time
     * @param DateTime $endDateTime the end date time
     * @return \DateInterval
     */
    public static function getDateInterval($startDateTime = null, $endDateTime)
    {
        if ($startDateTime === null) {
            $startDateTime = new DateTime;
        }

        if (is_string($startDateTime)) {
            $startDateTime = new DateTime($startDateTime);
        }

        if (is_string($endDateTime)) {
            $endDateTime = new DateTime($endDateTime);
        }

        return $startDateTime->diff($endDateTime);
    }

    /**
     * Converts a DateInterval object into seconds
     * 
     * @param \DateInterval $interval
     * @return int the seconds
     */
    public static function convertDateIntervalToSeconds(\DateInterval $interval)
    {
        return $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;
    }
}
