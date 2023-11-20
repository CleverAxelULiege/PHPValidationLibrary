<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;

class EmailRule extends AbstractRule{
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("L'adresse e-mail du champs " . $this->getPlaceHolder() . " n'est pas valide.");
        return preg_match("/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/i", $value);
    }
}