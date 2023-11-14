<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;
use ReflectionFunction;

class RequiredIfRule extends AbstractRuleDependentAnotherInput{

    public function __construct(string $keyFromAnotherInput, callable $needsToBeRequiredIf)
    {
        parent::__construct($keyFromAnotherInput, $needsToBeRequiredIf);
        $this->setIsKey(true);
    }
    
    public function isRuleValid(): bool
    {
        $this->setMessage("Le champs, " . $this->getPlaceHolder() . ", est requis car le champs " . $this->getPlaceHolder($this->getInput()) . " est vide.");
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        $reflectionFunc = new ReflectionFunction($this->callback);
        switch(count($reflectionFunc->getParameters())){
            case 1:
                if($this->getKey() == $this->getInput()){
                    if(call_user_func($this->callback, $value)){
                        $this->setIsRequired(true);
                        return false;
                    }
                } else {
                    if(call_user_func($this->callback, $valueFromAnotherInput)){
                        $this->setIsRequired(true);
                        return false;
                    }
                }
            break;

            case 2:
                if(call_user_func($this->callback, $value, $valueFromAnotherInput)){
                    $this->setIsRequired(true);
                    return false;
                }
            break;
        }
        return true;
    }
}