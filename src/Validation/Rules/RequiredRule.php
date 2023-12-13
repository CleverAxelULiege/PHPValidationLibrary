<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Validation\Rules\Parent\AbstractRule;


class RequiredRule extends AbstractRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessageDetails("required", 0, [
            AbstractRule::PLACEHOLDER => $this->getPlaceHolder()
        ]);

        return ValueHelper::isEmpty($value) == false;
    }
}