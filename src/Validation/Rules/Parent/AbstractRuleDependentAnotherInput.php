<?php

namespace App\Validation\Rules\Parent;

/**
 * @method void __construct(string $input)
 * @method void __construct(string $input, callable $callback)
 */
abstract class AbstractRuleDependentAnotherInput extends AbstractRule{

    protected mixed $callback;
    private string $input;
    private mixed $valueFromAnotherInput;
    // private bool $isRequired = false;
    // private bool $needsToBeExcluded = false;
    private bool $isKey = false;

    public function __construct(string $input, callable $callback = null)
    {
        $this->priority = AbstractRule::HIGH_PRIORITY;
        $this->callback = $callback;
        $this->input = $input;
    }

    protected function setIsKey(bool $isKey){
        $this->isKey = $isKey;
        return $this;
    }

    public function getIsKey(){
        return $this->isKey;
    }

    public function getValueFromAnotherInput(){
        return $this->valueFromAnotherInput ?? "";
    }

    // protected function setIsRequired(bool $isRequired){
    //     $this->isRequired = $isRequired;
    // }

    // public function getIsRequired(){
    //     return $this->isRequired;
    // }

    // protected function setNeedsToBeExcluded(bool $needsToBeExcluded){
    //     $this->needsToBeExcluded = $needsToBeExcluded;
    // }

    // public function getNeedsToBeExcluded(){
    //     return $this->needsToBeExcluded;
    // }

    /**
     * Peut renvoyer une valeur hard codée ou la clef d'un tableau dépend de ce qui a été passé dans le constructeur
     */
    public function getInput(){
        return $this->input;
    }

    public function setValueFromAnotherInput(mixed $value){
        if(is_string($value))
            $value = trim($value);

        $this->valueFromAnotherInput = $value;
        return $this;
    }
}