<?php

namespace App\Validation\Rules;

use App\Validation\Rules\AbstractRule;

class RequiredRule extends AbstractRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("Le champs, " . $this->getPlaceHolder() . ", est obligatoire");
        
        if(isset($value) == false || is_null($value)){
            return false;
        }

        if(is_string($value) && strlen(trim($value)) == 0){
            return false;
        }

        if(is_array($value) && count($value) == 0){
            return false;
        }

        return true;
    }
}