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
        $this->setMessageDetails("integer", 0, [
            ":placeholder" => $this->getPlaceHolder()
        ]);
        return NumberHelper::isInteger($this->getValue());
    }
}