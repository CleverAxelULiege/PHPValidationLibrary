<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;

class MustBeAfterOrEqualsTimeRule extends MustBeAfterTimeRule{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if($this->areBothTimesValids($value, $valueFromAnotherInput) == false){
            return false;
        }

        if($this->getIsKey()){
            $this->setMessageDetails("mustBeAfterTimeOrEquals", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                AbstractRule::OTHER_PLACEHOLDER => $this->getPlaceHolder($this->getInput()),
                ":time" => $value,
                ":other_time" => $valueFromAnotherInput,
            ]);
        }else{
            $this->setMessageDetails("mustBeAfterTimeOrEquals", 1, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                AbstractRule::OTHER_PLACEHOLDER => $this->getPlaceHolder($this->getInput()),
                ":time" => $value,
                ":other_time" => $valueFromAnotherInput,
            ]);
        }

        if(ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstTimeLaterOrEqualsThanSecond($value, $valueFromAnotherInput, $this->getFormat());

        return true;
    }
}