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

        if(NumberHelper::isFloat($value) == false){
            $this->setMessageDetails("min", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder()
            ]);
            return false;
        }

        if((float)$value > $this->minValue){
            $this->setMessageDetails("max", 1, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                ":min" => $this->minValue
            ]);
            return false;
        }

        if(NumberHelper::isInteger($value)){
            $this->setType("int");
        }

        return true;
    }
}