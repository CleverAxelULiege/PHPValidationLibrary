<?php

namespace App\Validation\Rules;

class EmailRule extends AbstractRule{
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("L'adresse mail du champs " . $this->getPlaceHolder() . " n'est pas valide.");
        return preg_match("/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/i", $value);
    }
}