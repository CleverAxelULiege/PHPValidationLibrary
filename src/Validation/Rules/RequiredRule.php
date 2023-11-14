<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Validation\Rules\Parent\AbstractRule;


class RequiredRule extends AbstractRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("Le champs, " . $this->getPlaceHolder() . ", est obligatoire");

        return ValueHelper::isEmpty($value) == false;
    }
}