<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

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

        if(call_user_func($this->callback, $value, $valueFromAnotherInput)){
            $this->setIsRequired(true);
            return false;
        }

        return true;
    }
}