<?php

namespace App\Validation\Rules;

use DateTime;
use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRuleDateOperation;

class MustBeAfterDateRule extends AbstractRuleDateOperation{
    
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        $this->setMessage("Date au format invalide dans le champs, " . $this->getPlaceHolder() .", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->setMessage("Date au format invalide, " . $this->getPlaceHolder($this->getInput())  . ", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($valueFromAnotherInput) && $this->getIsKey()){
            return false;
        }

        $this->messageInvalideDate($value);
        if(DateTimeHelper::validateDate($value, $this->format) == false){
            return false;
        }

        $this->messageInvalideDateFromInput($valueFromAnotherInput);
        if(ValueHelper::isEmpty($valueFromAnotherInput) == false && DateTimeHelper::validateDate($valueFromAnotherInput, $this->format) == false && $this->getIsKey()){
            return false;
        }

        if($this->getIsKey()){
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard dans le temps que la date que vous avez fournie depuis le champs " . $this->getPlaceHolder($this->getInput()) . ", dont la date est le " . $valueFromAnotherInput);
        }else{
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard dans le temps que le " . $valueFromAnotherInput);
        }
        
        if(ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstDateLaterThanSecond($value, $valueFromAnotherInput, $this->format);

        return true;
    }
}