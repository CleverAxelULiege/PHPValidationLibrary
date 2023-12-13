<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;

class BooleanRule extends AbstractRule{

    private ?bool $valueExpected = null;

    public function __construct(?bool $valueExpected = null)
    {
        $this->valueExpected = $valueExpected;
        $this->setType("bool");
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        
        $value = $value == "" ? false : true;
        $this->setValue($value);
        
        $this->setMessageDetails("boolean", 0, [
            ":placeholder" => $this->getPlaceHolder(),
            ":expectedValue" => ($this->valueExpected ? "TRUE" : "FALSE")
        ]);

        if($this->valueExpected !== null && (bool)$value !== $this->valueExpected){
            return false;
        }

        $this->setMessageDetails("boolean", 1, [
            ":placeholder" => $this->getPlaceHolder(),
        ]);
        return in_array($value, ["1", "0", 1, 0, true, false, "true", "false"]);
    }
}