<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;

class MustBeAfterOrEqualsTimeRule extends MustBeAfterTimeRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        $this->setMessage("Heure au format invalide dans le champs, " . $this->getPlaceHolder() .", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->setMessage("Heure au format invalide, " . $this->getPlaceHolder($this->getInput())  . ", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($valueFromAnotherInput) && $this->getIsKey()){
            return false;
        }

        $this->messageInvalideTime($value);
        if(DateTimeHelper::validateDate($value, $this->format) == false){
            return false;
        }

        $this->messageInvalideTimeFromInput($valueFromAnotherInput);
        if(ValueHelper::isEmpty($valueFromAnotherInput) == false && DateTimeHelper::validateDate($valueFromAnotherInput, $this->format) == false && $this->getIsKey()){
            return false;
        }

        if($this->getIsKey()){
            $this->setMessage("L'heure donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard ou égal dans le temps que l'heure que vous avez fournie depuis le champs " . $this->getPlaceHolder($this->getInput()) . ", dont l'heure est " . $valueFromAnotherInput);
        }else{
            $this->setMessage("L'heure donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard ou égal dans le temps que " . $valueFromAnotherInput);
        }

        if(ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstTimeLaterOrEqualsThanSecond($value, $valueFromAnotherInput);

        return true;
    }
}