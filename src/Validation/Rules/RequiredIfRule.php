<?php

namespace App\Validation\Rules;

class RequiredIfRule extends AbstractRuleDependantAnotherInput{
    
    public function isRuleValid(): bool
    {
        return true;
    }
}