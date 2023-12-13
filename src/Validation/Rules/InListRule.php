<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;

class InListRule extends AbstractRule
{
    private array $list;
    public function __construct(array $list)
    {
        $this->list = $list;
    }

    public function isRuleValid(): bool
    {
        $this->setMessageDetails("inList", 0, [
            ":placeholder" => $this->getPlaceHolder(),
            ":list" => implode(", ", $this->list),
        ]);
        return in_array($this->getValue(), $this->list);
    }
}