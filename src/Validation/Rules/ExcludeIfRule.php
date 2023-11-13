<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

class ExcludeIfRule extends AbstractRuleDependentAnotherInput {

    public function __construct(string $keyFromAnotherInput, callable $needsToBeExcludedIf)
    {
        parent::__construct($keyFromAnotherInput, $needsToBeExcludedIf);
        $this->setIsKey(true);
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if(call_user_func($this->callback, $value, $valueFromAnotherInput)){
            $this->setNeedsToBeExcluded(true);
        }
        
        return true;
    }

}