<?php

namespace App\Validation\Rules;

use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;

class TimeRule extends AbstractRule{
    private string $format = "H:i:s";

    public function __construct(string $format = "H:i")
    {
        $this->format = $format;
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setValue($value);
        $this->setMessage("L'heure venant du champs " . $this->getPlaceHolder() . " n'est pas valide.");
        
        if(!is_string($value)){
            return false;
        }
        
        return DateTimeHelper::validateTime($value, $this->format);
    }
}