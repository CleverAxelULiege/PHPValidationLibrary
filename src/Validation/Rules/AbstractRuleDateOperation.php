<?php

namespace App\Validation\Rules;

use App\Helper\DateTimeHelper;

/**
 * @method void __construct(?string $dateToCompare)
 * @method void __construct(?string $dateToCompare, bool $isFromInput = false, ?string $keyDateToCompare = null, string $format = "Y/m/d")
 */
abstract class AbstractRuleDateOperation extends AbstractRuleThrowableException
{
    protected string $format;
    protected ?string $dateToCompare;
    protected bool $isFromInput;
    protected ?string $keyDateToCompare = null;


    public function __construct(?string $dateToCompare, bool $isFromInput = false, ?string $keyDateToCompare = null, string $format = "Y/m/d")
    {
        $this->format = $format;
        $this->dateToCompare = is_null($dateToCompare) || (is_string($dateToCompare) && trim($dateToCompare) == "") ? null : $dateToCompare;
        $this->isFromInput = $isFromInput;
        $this->keyDateToCompare = $keyDateToCompare;
        $this->tryThrowRuleException();
    }

    protected function tryThrowRuleException()
    {
        if (str_contains($this->format, "Y") == false || str_contains($this->format, "m") == false | str_contains($this->format, "Y") == false) {
            throw new RuleException("The format need to incorporate at least Y/m/d");
        }

        if ($this->isFromInput == false && DateTimeHelper::validateDate($this->dateToCompare, $this->format) == false) {
            throw new RuleException("The date given (" . $this->dateToCompare . ") for comparison is invalid.");
        }
        if ($this->isFromInput && is_null($this->keyDateToCompare)) {
            throw new RuleException("No key given with the input");
        }
    }

    protected function messageInvalideDate(?string $date)
    {
        $this->setMessage("La date (" . ($date == null ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }
    protected function messageInvalideDateFromInput(?string $date)
    {
        $this->setMessage("La date (" . ($date == null ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder($this->keyDateToCompare) . " est invalide.");
    }
}
