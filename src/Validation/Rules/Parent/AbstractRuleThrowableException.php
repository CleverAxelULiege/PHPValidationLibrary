<?php

namespace App\Validation\Rules\Parent;

abstract class AbstractRuleThrowableException extends AbstractRule{
    protected abstract function tryThrowRuleException();
}