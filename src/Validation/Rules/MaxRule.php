<?php

namespace App\Validation\Rules;

use App\Helper\NumberHelper;
use App\Validation\Rules\Parent\AbstractRule;

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

        if(NumberHelper::isFloat($value) == false){
            $this->setMessageDetails("max", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder()
            ]);
            return false;
        }

        if((float)$value > $this->maxValue){
            $this->setMessageDetails("max", 1, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                ":max" => $this->maxValue
            ]);
            return false;
        }

        if(NumberHelper::isInteger($value)){
            $this->setType("int");
        }

        return true;
    }
}