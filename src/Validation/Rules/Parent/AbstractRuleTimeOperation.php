<?php

namespace App\Validation\Rules\Parent;

use App\Helper\DateTimeHelper;
use App\Validation\Rules\RuleException;

abstract class AbstractRuleTimeOperation extends AbstractRuleDependentAnotherInput
{
    protected string $format = "H:i";
    protected string $timeToCompare;

    public function __construct(?string $timeToCompare, bool $isKey = false)
    {
        $this->timeToCompare = is_null($timeToCompare) || (is_string($timeToCompare) && trim($timeToCompare) == "") ? null : $timeToCompare;
        parent::__construct($timeToCompare);
        $this->setIsKey($isKey);
        
        if($this->getIsKey() == false)
            $this->tryThrowRuleException();
    }

    protected function tryThrowRuleException()
    {
        if ($this->getIsKey() == false && DateTimeHelper::validateTime($this->timeToCompare, $this->format) == false) {
            throw new RuleException("The time (" . $this->timeToCompare . ") given for comparison is invalid. Is it a key or a hardcoded value and did you precise it ?");
        }
    }

    protected function messageInvalideTime(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }
    protected function messageInvalideTimeFromInput(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder($this->timeToCompare) . " est invalide.");
    }

    protected function areBothTimesString(mixed $value, mixed $valueFromAnotherInput){
        $this->setMessage("Heure au format invalide dans le champs, " . $this->getPlaceHolder() .", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->setMessage("Heure au format invalide, " . $this->getPlaceHolder($this->getInput())  . ", doit être sous une chaine de charactères au format " . $this->format);
        if(!is_string($valueFromAnotherInput) && $this->getIsKey()){
            return false;
        }
    }
}
