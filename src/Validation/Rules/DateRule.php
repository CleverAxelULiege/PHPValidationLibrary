<?php

namespace App\Validation\Rules;

use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;

class DateRule extends AbstractRule{

    private string $format;

    public function __construct($format= "Y/m/d")
    {
        $this->format = $format;
    }
    
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . " n'est pas valide");
        
        if(!is_string($value)){
            return false;
        }

        return DateTimeHelper::validateDate($value, $this->format);
    }
    
}