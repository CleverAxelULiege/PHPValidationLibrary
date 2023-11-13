<?php

namespace App\Validation\Rules\Parent;

use App\Helper\DateTimeHelper;
use App\Validation\Rules\RuleException;

/**
 * @method void __construct(?string $timeToCompare)
 * @method void __construct(?string $timeToCompare, bool $isFromInput = false, ?string $keytimeToCompare = null)
 */
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
        // if ($this->getIsKey() && is_null($this->keytimeToCompare)) {
        //     throw new RuleException("No key given with the input");
        // }
    }

    protected function messageInvalideTime(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }
    protected function messageInvalideTimeFromInput(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder($this->timeToCompare) . " est invalide.");
    }
}
