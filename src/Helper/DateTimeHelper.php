<?php

namespace App\Helper;

use DateTime;
use Exception;
use RuntimeException;
use UnexpectedValueException;

class DateTimeHelper
{
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

    private static function throwExceptionIfDatetimeFalse(DateTime|bool $firstDateTime, DateTime|bool $secondDatetime){
        if($firstDateTime == false || $secondDatetime == false){
            throw new Exception("One or both DateTimes are incorrect.");
        }
    }

    public static function isFirstDateSoonerThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        self::throwExceptionIfDatetimeFalse($formatFirstDate, $formatSecondDate);

        return $formatFirstDate->getTimestamp() < $formatSecondDate->getTimestamp();
    }

    public static function isFirstDateSoonerOrEqualsThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        self::throwExceptionIfDatetimeFalse($formatFirstDate, $formatSecondDate);

        return $formatFirstDate->getTimestamp() <= $formatSecondDate->getTimestamp();
    }

    public static function isFirstDateLaterThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        self::throwExceptionIfDatetimeFalse($formatFirstDate, $formatSecondDate);

        return $formatFirstDate->getTimestamp() > $formatSecondDate->getTimestamp();
    }

    public static function isFirstDateLaterOrEqualsThanSecond(string $firstDate, string $secondDate, $format = "Y/m/d")
    {
        $formatFirstDate = DateTime::createFromFormat($format, $firstDate);
        $formatSecondDate = DateTime::createFromFormat($format, $secondDate);
        self::throwExceptionIfDatetimeFalse($formatFirstDate, $formatSecondDate);

        return $formatFirstDate->getTimestamp() >= $formatSecondDate->getTimestamp();
    }


    /*************************/


    public static function isFirstTimeSoonerThanSecond(string $firstTime, string $secondTime, string $format = "H:i:s")
    {
        $formatFirstTime = DateTime::createFromFormat($format, $firstTime);
        $formatSecondTime = DateTime::createFromFormat($format, $secondTime);
        self::throwExceptionIfDatetimeFalse($formatFirstTime, $formatSecondTime);

        return $formatFirstTime->getTimestamp() < $formatSecondTime->getTimestamp();
    }

    public static function isFirstTimeSoonerOrEqualsThanSecond(string $firstTime, string $secondTime, string $format = "H:i:s")
    {
        $formatFirstTime = DateTime::createFromFormat($format, $firstTime);
        $formatSecondTime = DateTime::createFromFormat($format, $secondTime);
        self::throwExceptionIfDatetimeFalse($formatFirstTime, $formatSecondTime);

        return $formatFirstTime->getTimestamp() <= $formatSecondTime->getTimestamp();
    }

    public static function isFirstTimeLaterThanSecond(string $firstTime, string $secondTime, string $format = "H:i:s")
    {
        $formatFirstTime = DateTime::createFromFormat($format, $firstTime);
        $formatSecondTime = DateTime::createFromFormat($format, $secondTime);
        self::throwExceptionIfDatetimeFalse($formatFirstTime, $formatSecondTime);

        return $formatFirstTime->getTimestamp() > $formatSecondTime->getTimestamp();
    }

    public static function isFirstTimeLaterOrEqualsThanSecond(string $firstTime, string $secondTime, string $format = "H:i:s")
    {
        $formatFirstTime = DateTime::createFromFormat($format, $firstTime);
        $formatSecondTime = DateTime::createFromFormat($format, $secondTime);
        self::throwExceptionIfDatetimeFalse($formatFirstTime, $formatSecondTime);

        return $formatFirstTime->getTimestamp() >= $formatSecondTime->getTimestamp();
    }
}
