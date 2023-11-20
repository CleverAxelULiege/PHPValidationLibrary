<?php

namespace App\Validation\Rules\Parent;

use App\Helper\DateTimeHelper;
use App\Helper\ValueHelper;
use App\Validation\Rules\RuleException;


abstract class AbstractRuleDateOperation extends AbstractRuleDependentAnotherInput
{
    private string $format;
    private string $dateToCompare;

    public function __construct(string $dateToCompare, bool $isKey = false, string $format = "Y/m/d")
    {
        $this->format = $format;
        $this->dateToCompare = $dateToCompare;
        parent::__construct($dateToCompare);
        $this->setIsKey($isKey);
        
        if($this->getIsKey() == false)
            $this->tryThrowRuleException();
    }

    private function tryThrowRuleException()
    {
        if (DateTimeHelper::validateDate($this->dateToCompare, $this->format) == false) {
            throw new RuleException("The date given (" . $this->dateToCompare . ") for comparison is invalid. Is it a key or a hardcoded value and did you precise it ?");
        }
    }

    protected function getFormat(){
        return $this->format;
    }

    private function messageInvalideDate(?string $date)
    {
        $this->setMessage("La date (" . ($date == null || $date == "" ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }

    private function messageInvalideDateFromInput(?string $date)
    {
        $this->setMessage("La date (" . ($date == null || $date == "" ? "INCONNUE" : $date) . ") venant du champs " . $this->getPlaceHolder($this->dateToCompare) . " est invalide.");
    }

    private function areBothDatesString(mixed $value, mixed $valueFromAnotherInput) : bool {
        $this->setMessage("Date au format invalide venant du champs " . $this->getPlaceHolder() .". Elle doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->setMessage("Date au format invalide venant du champs " . $this->getPlaceHolder($this->getInput())  . ". Elle doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($valueFromAnotherInput) && $this->getIsKey()){
            return false;
        }

        return true;
    }

    protected function areBothDatesValids(mixed $value, mixed $valueFromAnotherInput) : bool {
        if($this->areBothDatesString($value, $valueFromAnotherInput) == false){
            return false;
        }

        $this->messageInvalideDate($value);
        if(DateTimeHelper::validateDate($value, $this->format) == false){
            return false;
        }

        $this->messageInvalideDateFromInput($valueFromAnotherInput);
        if(ValueHelper::isEmpty($valueFromAnotherInput) == false && DateTimeHelper::validateDate($valueFromAnotherInput, $this->format) == false && $this->getIsKey()){
            return false;
        }

        return true;
    }
}
