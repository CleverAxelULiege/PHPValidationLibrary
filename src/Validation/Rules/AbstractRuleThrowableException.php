<?php

namespace App\Validation\Rules;

abstract class AbstractRuleThrowableException extends AbstractRule{
    protected abstract function tryThrowRuleException();
}