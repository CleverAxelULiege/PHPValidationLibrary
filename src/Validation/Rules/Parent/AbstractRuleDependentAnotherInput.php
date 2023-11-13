<?php

namespace App\Validation\Rules\Parent;

/**
 * @method void __construct(string $keyFromAnotherInput)
 * @method void __construct(string $keyFromAnotherInput, callable $callback)
 */
abstract class AbstractRuleDependentAnotherInput extends AbstractRule{

    protected mixed $callback;
    private string $keyFromAnotherInput;
    private mixed $valueFromAnotherInput;
    private bool $isRequired = false;

    public function __construct(string $keyFromAnotherInput, callable $callback = null)
    {
        $this->callback = $callback;
        $this->keyFromAnotherInput = $keyFromAnotherInput;
    }

    public function getValueFromAnotherInput(){
        return $this->valueFromAnotherInput;
    }

    public function setIsRequired(bool $isRequired){
        $this->isRequired = $isRequired;
    }

    public function getIsRequired(){
        return $this->isRequired;
    }

    public function getKeyFromAnotherInput(){
        return $this->keyFromAnotherInput;
    }

    public function setValueFromAnotherInput(mixed $value){
        $this->valueFromAnotherInput = $value;
    }
}