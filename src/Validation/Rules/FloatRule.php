<?php

namespace App\Validation\Rules;

use App\Helper\NumberHelper;
use App\Validation\Rules\Parent\AbstractRule;

class FloatRule extends AbstractRule{

    public function __construct()
    {
        $this->setType("float");
    }

    public function isRuleValid(): bool
    {
        // $this->setMessage("La valeur du champs " . $this->getPlaceHolder() ." n'est pas un nombre ou un nombre à virgule");
        $this->setMessageDetails("float", 0, [
            ":placeholder" => $this->getPlaceHolder()
        ]);
        return NumberHelper::isFloat($this->getValue());
    }
}