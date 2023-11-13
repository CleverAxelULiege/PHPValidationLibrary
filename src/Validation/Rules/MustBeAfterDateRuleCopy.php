<?php

namespace App\Validation\Rules;

use DateTime;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRuleDateOperation;
use App\Validation\Rules\Parent\AbstractRuleDateOperationCopy;

class MustBeAfterDateRuleCopy extends AbstractRuleDateOperationCopy{


    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        $this->setMessage("Date au format invalide. Doit être sous chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->messageInvalideDate($value);
        if(DateTimeHelper::validateDate($value, $this->format) == false){
            return false;
        }

        $this->messageInvalideDateFromInput($valueFromAnotherInput);
        if($valueFromAnotherInput != null && DateTimeHelper::validateDate($valueFromAnotherInput, $this->format) == false && $this->getIsHardcoded() == false){
            return false;
        }

        if($this->getIsHardcoded() == false){
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard dans le temps que la date que vous avez fournie depuis le champs " . $this->getPlaceHolder($this->getInput()) . ", dont la date est le " . $valueFromAnotherInput);
        }else{
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard dans le temps que le " . $valueFromAnotherInput);
        }
        
        if($valueFromAnotherInput != null)
            return DateTimeHelper::isFirstDateLaterThanSecond($value, $valueFromAnotherInput, $this->format);

        return true;
    }
}