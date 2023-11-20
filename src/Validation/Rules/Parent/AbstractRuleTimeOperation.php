<?php

namespace App\Validation\Rules\Parent;

use App\Helper\ValueHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\RuleException;

abstract class AbstractRuleTimeOperation extends AbstractRuleDependentAnotherInput
{
    private string $format = "H:i:s";
    private string $timeToCompare;

    public function __construct(?string $timeToCompare, bool $isKey = false, string $format = "H:i")
    {
        $this->timeToCompare = $timeToCompare;
        $this->format = $format;
        parent::__construct($timeToCompare);
        $this->setIsKey($isKey);
        
        if($this->getIsKey() == false)
            $this->tryThrowRuleException();
    }

    private function tryThrowRuleException()
    {
        if (DateTimeHelper::validateTime($this->timeToCompare, $this->format) == false) {
            throw new RuleException("The time (" . $this->timeToCompare . ") given for comparison is invalid. Is it a key or a hardcoded value and did you precise it ?");
        }
    }

    protected function getFormat(){
        return $this->format;
    }

    private function messageInvalideTime(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null || $time == "" ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }

    private function messageInvalideTimeFromInput(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null || $time == "" ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder($this->timeToCompare) . " est invalide.");
    }

    private function areBothTimesString(mixed $value, mixed $valueFromAnotherInput) : bool{
        $this->setMessage("Heure au format invalide venant du champs " . $this->getPlaceHolder() .". Elle doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }
        
        $this->setMessage("Heure au format invalide venant du champs " . $this->getPlaceHolder($this->getInput())  . ". Elle doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($valueFromAnotherInput) && $this->getIsKey()){
            return false;
        }

        return true;
    }

    protected function areBothTimesValids(mixed $value, mixed $valueFromAnotherInput) : bool{
        if($this->areBothTimesString($value, $valueFromAnotherInput) == false){
            return false;
        }

        $this->messageInvalideTime($value);
        if(DateTimeHelper::validateTime($value, $this->format) == false){
            return false;
        }

        $this->messageInvalideTimeFromInput($valueFromAnotherInput);
        if(ValueHelper::isEmpty($valueFromAnotherInput) == false && DateTimeHelper::validateTime($valueFromAnotherInput, $this->format) == false && $this->getIsKey()){
            return false;
        }

        return true;
    }
}
