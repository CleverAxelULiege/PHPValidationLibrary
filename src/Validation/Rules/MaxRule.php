<?php

namespace App\Validation\Rules;

use App\Helper\NumberHelper;

class MaxRule extends AbstractRule{
    private float $maxValue;

    public function __construct(float $maxValue)
    {
        $this->setType("float");
        $this->maxValue = $maxValue;
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();

        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() ." n'est pas un nombre");
        if(NumberHelper::isFloat($value) == false)
            return false;

        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() . " ne peut pas être plus grande que : " . $this->maxValue);
        if((float)$value > $this->maxValue)
            return false;

        return true;
    }
}