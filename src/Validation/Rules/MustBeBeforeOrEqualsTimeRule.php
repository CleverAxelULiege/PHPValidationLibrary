<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRuleTimeOperation;

class MustBeBeforeOrEqualsTimeRule extends AbstractRuleTimeOperation{
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
            $this->setMessage("L'heure donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tôt ou égal dans le temps que l'heure que vous avez fournie depuis le champs " . $this->getPlaceHolder($this->getInput()) . ", dont l'heure est " . $valueFromAnotherInput);
        }else{
            $this->setMessage("L'heure donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tôt ou égal dans le temps que " . $valueFromAnotherInput);
        }

        if(ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstTimeSoonerOrEqualsThanSecond($value, $valueFromAnotherInput);

        return true;
    }
}