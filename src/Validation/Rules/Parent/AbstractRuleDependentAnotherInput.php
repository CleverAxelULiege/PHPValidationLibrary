<?php

namespace App\Validation\Rules\Parent;


abstract class AbstractRuleDependentAnotherInput extends AbstractRule{

    protected mixed $callback;
    private string $input;
    private mixed $valueFromAnotherInput;
    private bool $isKey = false;

    public function __construct(string $input, callable $callback = null)
    {
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