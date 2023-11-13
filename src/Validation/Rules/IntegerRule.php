<?php

namespace App\Validation\Rules;

use App\Helper\NumberHelper;
use App\Validation\Rules\Parent\AbstractRule;

class IntegerRule extends AbstractRule{

    public function __construct()
    {
        $this->setType("int");
    }

    public function isRuleValid(): bool
    {
        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() ." n'est pas un nombre entier");

        return NumberHelper::isInteger($this->getValue());
    }
}