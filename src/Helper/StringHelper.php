<?php

namespace App\Helper;

class StringHelper{
    /**
     * Enlève les slash, backslash, point, espace, underscore, dash, plus
     */
    public static function removeCommonsSeparations(string $value) : string{
        return preg_replace("/[\\\|\-|\/| |\s|\.|+]/", "", $value);
    }
}