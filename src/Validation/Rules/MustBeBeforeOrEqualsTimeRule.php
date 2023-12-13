<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleTimeOperation;

class MustBeBeforeOrEqualsTimeRule extends AbstractRuleTimeOperation{
    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if($this->areBothTimesValids($value, $valueFromAnotherInput) == false){
            return false;
        }

        if($this->getIsKey()){
            $this->setMessageDetails("mustBeBeforeTimeOrEquals", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                AbstractRule::OTHER_PLACEHOLDER => $this->getPlaceHolder($this->getInput()),
                ":time" => $value,
                ":other_time" => $valueFromAnotherInput,
            ]);
        }else{
            $this->setMessageDetails("mustBeBeforeTimeOrEquals", 1, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                AbstractRule::OTHER_PLACEHOLDER => $this->getPlaceHolder($this->getInput()),
                ":time" => $value,
                ":other_time" => $valueFromAnotherInput,
            ]);
        }

        if(ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstTimeSoonerOrEqualsThanSecond($value, $valueFromAnotherInput, $this->getFormat());

        return true;
    }
}