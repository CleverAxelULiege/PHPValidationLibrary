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
        $this->setMessage("La valeur du champs ". $this->getPlaceHolder() ."  n'est pas la valeur booléenne expectée : " . ($this->valueExpected ? "TRUE" : "FALSE"));

        $value = $value == "" ? false : true;
        $this->setValue($value);

        if($this->valueExpected != null && $value != $this->valueExpected){
            return false;
        }

        $this->setMessage("La valeur du champs ". $this->getPlaceHolder() ."  n'est pas une valeur booléenne correcte");
        return in_array($value, ["1", "0", 1, 0, true, false, "true", "false"]);
    }
}