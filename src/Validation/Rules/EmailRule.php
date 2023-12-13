<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;

class EmailRule extends AbstractRule{
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessageDetails("email", 0, [
            ":placeholder" => $this->getPlaceHolder()
        ]);
        return preg_match("/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/i", $value);
    }
}