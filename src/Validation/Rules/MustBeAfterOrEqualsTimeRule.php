<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;

class MustBeAfterOrEqualsTimeRule extends MustBeAfterTimeRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if($this->areBothTimesString($value, $valueFromAnotherInput) == false){
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