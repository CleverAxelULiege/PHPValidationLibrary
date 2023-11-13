<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

class RequiredIfRule extends AbstractRuleDependentAnotherInput{

    public function __construct(string $keyFromAnotherInput, callable $needsToBeRequiredIf, string $errorMessage)
    {
        parent::__construct($keyFromAnotherInput, $needsToBeRequiredIf);
        $this->setMessage($errorMessage);
    }
    
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if(call_user_func($this->callback, $value, $valueFromAnotherInput)){
            $this->setIsRequired(true);
            return false;
        }

        return true;
    }
}