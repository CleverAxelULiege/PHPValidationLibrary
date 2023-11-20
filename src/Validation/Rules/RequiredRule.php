<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Validation\Rules\Parent\AbstractRule;


class RequiredRule extends AbstractRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() . " est obligatoire et ne peut pas être composée uniquement d'espaces.");

        return ValueHelper::isEmpty($value) == false;
    }
}