<?php

namespace App\Validation\Rules\Parent;

use App\Helper\DateTimeHelper;
use App\Helper\ValueHelper;
use App\Validation\Rules\RuleException;


abstract class AbstractRuleDateOperation extends AbstractRuleDependentAnotherInput
{
    protected string $format;
    protected string $dateToCompare;

    public function __construct(string $dateToCompare, bool $isKey = false, string $format = "Y/m/d")
    {
        $this->format = $format;
        $this->dateToCompare = is_null($dateToCompare) || (is_string($dateToCompare) && trim($dateToCompare) == "") ? null : $dateToCompare;;
        parent::__construct($dateToCompare);
        $this->setIsKey($isKey);
        
        if($this->getIsKey() == false)
            $this->tryThrowRuleException();
    }

    protected function tryThrowRuleException()
    {
        if (str_contains($this->format, "Y") == false || str_contains($this->format, "m") == false | str_contains($this->format, "Y") == false) {
            throw new RuleException("The format need to incorporate at least Y/m/d");
        }

        if ($this->getIsKey() == false && DateTimeHelper::validateDate($this->dateToCompare, $this->format) == false) {
            throw new RuleException("The date given (" . $this->dateToCompare . ") for comparison is invalid. Is it a key or a hardcoded value and did you precise it ?");
        }

        // if(ValueHelper::isEmpty($this->dateToCompare)){
        //     throw new RuleException("No comparaison date given.");
        // }
    }

    protected function messageInvalideDate(?string $date)
    {
        $this->setMessage("La date (" . ($date == null ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }

    protected function messageInvalideDateFromInput(?string $date)
    {
        $this->setMessage("La date (" . ($date == null ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder($this->dateToCompare) . " est invalide.");
    }

    protected function areBothDatesString(mixed $value, mixed $valueFromAnotherInput){
        $this->setMessage("Date au format invalide dans le champs, " . $this->getPlaceHolder() .", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->setMessage("Date au format invalide, " . $this->getPlaceHolder($this->getInput())  . ", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($valueFromAnotherInput) && $this->getIsKey()){
            return false;
        }

        return true;
    }
}
