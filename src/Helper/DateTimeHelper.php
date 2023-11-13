<?php

namespace App\Helper;

use DateTime;
use Exception;
use UnexpectedValueException;

class DateTimeHelper
{

    private static $timeFormat = "H:i";

    public static function validateDate(string $date, $format = "Y/m/d")
    {
        $formatDate = DateTime::createFromFormat($format, $date);
        //si la date est totalement erronée 
        //(ex: une string vide il renverra directement FALSE et ne passera pas par la méthode format)
        return $formatDate && $formatDate->format($format) == $date;
    }

    public static function validateTime(string $time, $format = "H:i:s")
    {
        $formatTime = DateTime::createFromFormat($format, $time);
        return $formatTime && $formatTime->format($format) == $time;
    }

    private static function doesFirstDateMatchOperationAndIsSooner(DateTime $formatFirstDate, DateTime $formatSecondDate, string $operation)
    {
        $firstYear = (int)$formatFirstDate->format("Y");
        $secondYear = (int)$formatSecondDate->format("Y");

        if ($firstYear < $secondYear) {
            return true;
        }

        $firstMonth = (int)$formatFirstDate->format("m");
        $secondMonth = (int)$formatSecondDate->format("m");

        if ($firstYear == $secondYear && $firstMonth < $secondMonth) {
            return true;
        }

        $firstDay = (int)$formatFirstDate->format("d");
        $secondDay = (int)$formatSecondDate->format("d");

        switch ($operation) {
            case "<=":
                if ($firstYear == $secondYear && $firstMonth == $secondMonth && $firstDay <= $secondDay) {
                    return true;
                }
                break;
            case "<":
                if ($firstYear == $secondYear && $firstMonth == $secondMonth && $firstDay < $secondDay) {
                    return true;
                }
                break;
            default:
                throw new Exception("Can only be '<' or '<=' sign.");
                break;
        }

        return false;
    }

    private static function doesFirstDateMatchOperationAndIsLater(DateTime $formatFirstDate, DateTime $formatSecondDate, string $operation)
    {
        $firstYear = (int)$formatFirstDate->format("Y");
        $secondYear = (int)$formatSecondDate->format("Y");

        if ($firstYear > $secondYear) {
            return true;
        }

        $firstMonth = (int)$formatFirstDate->format("m");
        $secondMonth = (int)$formatSecondDate->format("m");

        if ($firstYear == $secondYear && $firstMonth > $secondMonth) {
            return true;
        }

        $firstDay = (int)$formatFirstDate->format("d");
        $secondDay = (int)$formatSecondDate->format("d");

        switch ($operation) {
            case ">=":
                if ($firstYear == $secondYear && $firstMonth == $secondMonth && $firstDay >= $secondDay) {
                    return true;
                }
                break;
            case ">":
                if ($firstYear == $secondYear && $firstMonth == $secondMonth && $firstDay > $secondDay) {
                    return true;
                }
                break;
            default:
                throw new Exception("Can only be '>' or '>=' sign.");
                break;
        }

        return false;
    }

    private static function doesFirstTimeMatchOperationAndIsLater(DateTime $formatFirstTime, DateTime $formatSecondTime, string $operation)
    {
        $firstHour = (int)$formatFirstTime->format("H");
        $secondHour = (int)$formatSecondTime->format("H");

        if ($firstHour > $secondHour) {
            return true;
        }

        $firstMinute = (int)$formatFirstTime->format("i");
        $secondMinute = (int)$formatSecondTime->format("i");

        switch ($operation) {
            case ">=":
                if ($firstHour == $secondHour && $firstMinute >= $secondMinute) {
                    return true;
                }
                break;
            case ">":
                if ($firstHour == $secondHour && $firstMinute > $secondMinute) {
                    return true;
                }
                break;
            default:
                throw new Exception("Can only be '>' or '>=' sign.");
                break;
        }
        return false;
    }

    private static function doesFirstTimeMatchOperationAndIsSooner(DateTime $formatFirstTime, DateTime $formatSecondTime, string $operation)
    {
        $firstHour = (int)$formatFirstTime->format("H");
        $secondHour = (int)$formatSecondTime->format("H");

        if ($firstHour < $secondHour) {
            return true;
        }

        $firstMinute = (int)$formatFirstTime->format("i");
        $secondMinute = (int)$formatSecondTime->format("i");

        switch ($operation) {
            case "<=":
                if ($firstHour == $secondHour && $firstMinute <= $secondMinute) {
                    return true;
                }
                break;
            case "<":
                if ($firstHour == $secondHour && $firstMinute < $secondMinute) {
                    return true;
                }
                break;
            default:
                throw new Exception("Can only be '<' or '<=' sign.");
                break;
        }
        return false;
    }

    public static function isFirstDateSoonerThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        return self::doesFirstDateMatchOperationAndIsSooner($formatFirstDate, $formatSecondDate, "<");
    }

    public static function isFirstDateSoonerOrEqualsThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        return self::doesFirstDateMatchOperationAndIsSooner($formatFirstDate, $formatSecondDate, "<=");
    }

    public static function isFirstDateLaterThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        return self::doesFirstDateMatchOperationAndIsLater($formatFirstDate, $formatSecondDate, ">");
    }

    public static function isFirstDateLaterOrEqualsThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        return self::doesFirstDateMatchOperationAndIsLater($formatFirstDate, $formatSecondDate, ">=");
    }


    /*************************/


    public static function isFirstTimeSoonerThanSecond(string $firstTime, string $secondTime)
    {
        $formatFirstTime = DateTime::createFromFormat(self::$timeFormat, $firstTime);
        $formatSecondTime = DateTime::createFromFormat(self::$timeFormat, $secondTime);

        return self::doesFirstTimeMatchOperationAndIsSooner($formatFirstTime, $formatSecondTime, "<");
    }

    public static function isFirstTimeSoonerOrEqualsThanSecond(string $firstTime, string $secondTime)
    {
        $formatFirstTime = DateTime::createFromFormat(self::$timeFormat, $firstTime);
        $formatSecondTime = DateTime::createFromFormat(self::$timeFormat, $secondTime);

        return self::doesFirstTimeMatchOperationAndIsSooner($formatFirstTime, $formatSecondTime, "<=");
    }

    public static function isFirstTimeLaterThanSecond(string $firstTime, string $secondTime)
    {
        $formatFirstTime = DateTime::createFromFormat(self::$timeFormat, $firstTime);
        $formatSecondTime = DateTime::createFromFormat(self::$timeFormat, $secondTime);

        return self::doesFirstTimeMatchOperationAndIsLater($formatFirstTime, $formatSecondTime, ">");
    }

    public static function isFirstTimeLaterOrEqualsThanSecond(string $firstTime, string $secondTime)
    {
        $formatFirstTime = DateTime::createFromFormat(self::$timeFormat, $firstTime);
        $formatSecondTime = DateTime::createFromFormat(self::$timeFormat, $secondTime);

        return self::doesFirstTimeMatchOperationAndIsLater($formatFirstTime, $formatSecondTime, ">=");
    }

}
