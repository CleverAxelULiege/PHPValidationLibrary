<?php

namespace App\Validation\Rules\Parent;

use App\Helper\DateTimeHelper;
use App\Helper\ValueHelper;
use App\Validation\Rules\RuleException;


abstract class AbstractRuleDateOperationCopy extends AbstractRuleDependentAnotherInput
{
    protected string $format;
    protected string $dateToCompare;

    public function __construct(string $dateToCompare, bool $isHardCoded = false, string $format = "Y/m/d")
    {
        $this->format = $format;
        $this->dateToCompare = $dateToCompare;
        parent::__construct($dateToCompare);
        $this->setIsHardCoded($isHardCoded);
        $this->tryThrowRuleException();
    }

    protected function tryThrowRuleException()
    {
        if (str_contains($this->format, "Y") == false || str_contains($this->format, "m") == false | str_contains($this->format, "Y") == false) {
            throw new RuleException("The format need to incorporate at least Y/m/d");
        }

        if ($this->getIsHardcoded() && DateTimeHelper::validateDate($this->dateToCompare, $this->format) == false) {
            throw new RuleException("The date given (" . $this->dateToCompare . ") for comparison is invalid.");
        }

        if(ValueHelper::isEmpty($this->dateToCompare)){
            throw new RuleException("No comparaison date given.");
        }
    }

    protected function messageInvalideDate(?string $date)
    {
        $this->setMessage("La date (" . ($date == null ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }

    protected function messageInvalideDateFromInput(?string $date)
    {
        $this->setMessage("La date (" . ($date == null ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder($this->dateToCompare) . " est invalide.");
    }
}
