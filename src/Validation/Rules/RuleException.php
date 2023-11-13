<?php

namespace App\Validation\Rules;

use Exception;
use Throwable;

class RuleException extends Exception{

    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}