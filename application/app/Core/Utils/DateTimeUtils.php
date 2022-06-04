<?php
declare(strict_types=1);

namespace App\Core\Utils;

use DateTime;

/**
 * 日期工具类
 */
class DateTimeUtils
{

    public const DATE_FORMAT = 'Y-m-d';
    public const TIME_FORMAT = 'H:i:s';
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public static function formatDateTime(DateTime $date): string
    {
        return date_format($date, DateTimeUtils::DATE_TIME_FORMAT);
    }

    public static function formatDate(DateTime $date): string
    {
        return date_format($date, DateTimeUtils::DATE_FORMAT);
    }

    public static function formatTime(DateTime $date): string
    {
        return date_format($date, DateTimeUtils::TIME_FORMAT);
    }

}
