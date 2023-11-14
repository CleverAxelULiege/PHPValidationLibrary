<?php

namespace App\Helper;

class ValueHelper{
    public static function isEmpty(mixed $value){
        if(isset($value) == false){
            return true;
        }

        if(is_string($value) && empty(trim($value))){
            return true;
        }

        if(is_array($value) && empty($value)){
            return true;
        }

        return false;
    }
}