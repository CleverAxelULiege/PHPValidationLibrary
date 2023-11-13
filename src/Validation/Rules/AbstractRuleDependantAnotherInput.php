<?php

namespace App\Validation\Rules;

abstract class AbstractRuleDependantAnotherInput extends AbstractRule{

    protected callable $isValueRespected;
    protected string $keyAnotherInput;

    public function __construct(string $keyAnotherInput, callable $isValueRespected)
    {
        $this->isValueRespected = $isValueRespected;
        $this->keyAnotherInput = $keyAnotherInput;
    }
}