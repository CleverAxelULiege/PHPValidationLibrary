<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleDateOperation;

class MustBeAfterDateRule extends AbstractRuleDateOperation
{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if ($this->areBothDatesValids($value, $valueFromAnotherInput) == false) {
            return false;
        }

        if ($this->getIsKey()) {
            $this->setMessageDetails("mustBeAfterDate", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                AbstractRule::OTHER_PLACEHOLDER =>  $this->getPlaceHolder($this->getInput()),
                ":date" => $value,
                ":other_date" => $valueFromAnotherInput
            ]);
        } else {
            $this->setMessageDetails("mustBeAfterDate", 1, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                ":date" => $value,
                ":other_date" => $valueFromAnotherInput
            ]);
        }

        if (ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstDateLaterThanSecond($value, $valueFromAnotherInput, $this->getFormat());

        return true;
    }
}
