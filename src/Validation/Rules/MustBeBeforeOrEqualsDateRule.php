<?php

namespace App\Validation\Rules;

use DateTime;
use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRuleDateOperation;

class MustBeBeforeOrEqualsDateRule extends AbstractRuleDateOperation
{

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        if ($this->areBothDatesString($value, $valueFromAnotherInput) == false) {
            return false;
        }

        $this->messageInvalideDate($value);
        if (DateTimeHelper::validateDate($value, $this->format) == false) {
            return false;
        }

        $this->messageInvalideDateFromInput($valueFromAnotherInput);
        if (ValueHelper::isEmpty($valueFromAnotherInput) == false && DateTimeHelper::validateDate($valueFromAnotherInput, $this->format) == false && $this->getIsKey()) {
            return false;
        }

        if ($this->getIsKey()) {
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tôt ou égal dans le temps que la date que vous avez fournie depuis le champs " . $this->getPlaceHolder($this->getInput()) . ", dont la date est le " . $valueFromAnotherInput);
        } else {
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tôt ou égal dans le temps que le " . $valueFromAnotherInput);
        }

        if (ValueHelper::isEmpty($valueFromAnotherInput) == false)
            return DateTimeHelper::isFirstDateSoonerOrEqualsThanSecond($value, $valueFromAnotherInput, $this->format);

        return true;
    }
}
