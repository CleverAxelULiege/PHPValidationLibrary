<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;

class BelgianIBANRule extends AbstractRule{
    public function isRuleValid(): bool
    {
        
        $this->setMessageDetails("belgianIbanRule", 0, [
            ":placeholder" => $this->getPlaceHolder()
        ]);

        if(!is_string($this->getValue()))
            return false;
        
        return preg_match("/^BE\d{2}\s*?\d{4}\s*?\d{4}\s*?\d{4}$/", $this->getValue());
    }
}