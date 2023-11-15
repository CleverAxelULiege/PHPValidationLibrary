<?php

namespace App\Validation\Rules;

use App\Helper\NumberHelper;
use App\Validation\Rules\Parent\AbstractRule;

class MinRule extends AbstractRule{
    private float $minValue;

    public function __construct(float $minValue)
    {
        $this->setType("float");
        $this->minValue = $minValue;
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();

        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() ." n'est pas un nombre");
        if(NumberHelper::isFloat($value) == false){
            return false;
        }

        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() . " ne peut pas être plus petite que : " . $this->minValue);
        if((float)$value < $this->minValue){
            return false;
        }

        if(NumberHelper::isInteger($value)){
            $this->setType("int");
        }

        return true;
    }
}