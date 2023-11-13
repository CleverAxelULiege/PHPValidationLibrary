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
    private bool $isRequired = false;
    private bool $needsToBeExcluded = false;
    private bool $isHardCoded = false;

    public function __construct(string $input, callable $callback = null)
    {
        $this->callback = $callback;
        $this->input = $input;
    }

    protected function setIsHardCoded(bool $hardCoded){
        $this->isHardCoded = $hardCoded;
        return $this;
    }

    public function getIsHardcoded(){
        return $this->isHardCoded;
    }

    public function getValueFromAnotherInput(){
        return $this->valueFromAnotherInput;
    }

    protected function setIsRequired(bool $isRequired){
        $this->isRequired = $isRequired;
    }

    public function getIsRequired(){
        return $this->isRequired;
    }

    protected function setNeedsToBeExcluded(bool $needsToBeExcluded){
        $this->needsToBeExcluded = $needsToBeExcluded;
    }

    public function getNeedsToBeExcluded(){
        return $this->needsToBeExcluded;
    }

    /**
     * Peut renvoyer une valeur hard codée ou la clef d'un tableau dépend ce qui a été passé dans le constructeur
     */
    public function getInput(){
        return $this->input;
    }

    public function setValueFromAnotherInput(mixed $value){
        $this->valueFromAnotherInput = $value;
        return $this;
    }
}