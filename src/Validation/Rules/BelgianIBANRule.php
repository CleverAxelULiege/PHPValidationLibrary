<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;

class BelgianIBANRule extends AbstractRule{
    public function isRuleValid(): bool
    {
        $this->setMessage("Le numéro de compte IBAN belge venant du champs ". $this->getPlaceHolder() ." n'est pas valide. Vérifiez que les deux premières lettres BE soient en majuscules et respectez les espaces ou n'en mettez pas.");
        
        if(!is_string($this->getValue()))
            return false;
        
        return preg_match("/^BE\d{2}\s*?\d{4}\s*?\d{4}\s*?\d{4}$/", $this->getValue());
    }
}