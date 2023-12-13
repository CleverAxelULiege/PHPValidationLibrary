<?php

namespace App\Validation\Rules;

use DateTime;
use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleDateOperation;

class MustBeBeforeOrEqualsDateRule extends AbstractRuleDateOperation
{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if($this->areBothDatesValids($value, $valueFromAnotherInput) == false){
            return false;
        }

        if ($this->getIsKey()) {
            $this->setMessageDetails("mustBeBeforeDateOrEquals", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                AbstractRule::OTHER_PLACEHOLDER =>  $this->getPlaceHolder($this->getInput()),
                ":date" => $value,
                ":other_date" => $valueFromAnotherInput
            ]);
        } else {
            $this->setMessageDetails("mustBeBeforeDateOrEquals", 1, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                ":date" => $value,
                ":other_date" => $valueFromAnotherInput
            ]);
        }

        if (ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstDateSoonerOrEqualsThanSecond($value, $valueFromAnotherInput, $this->getFormat());

        return true;
    }
}
