<?php

namespace App\Validation\Rules\Parent;

use App\Helper\DateTimeHelper;
use App\Validation\Rules\RuleException;

/**
 * @method void __construct(?string $timeToCompare)
 * @method void __construct(?string $timeToCompare, bool $isFromInput = false, ?string $keytimeToCompare = null)
 */
abstract class AbstractRuleTimeOperation extends AbstractRuleThrowableException
{
    protected string $format = "H:i";
    protected ?string $timeToCompare;
    protected bool $isFromInput;
    protected ?string $keytimeToCompare = null;

    public function __construct(?string $timeToCompare, bool $isFromInput = false, ?string $keytimeToCompare = null)
    {
        $this->timeToCompare = is_null($timeToCompare) || (is_string($timeToCompare) && trim($timeToCompare) == "") ? null : $timeToCompare;
        $this->isFromInput = $isFromInput;
        $this->keytimeToCompare = $keytimeToCompare;
        $this->tryThrowRuleException();
    }

    protected function tryThrowRuleException()
    {
        if ($this->isFromInput == false && DateTimeHelper::validateTime($this->timeToCompare, $this->format) == false) {
            throw new RuleException("The time (" . $this->timeToCompare . ") given for comparison is invalid.");
        }
        if ($this->isFromInput && is_null($this->keytimeToCompare)) {
            throw new RuleException("No key given with the input");
        }
    }

    protected function messageInvalideTime(?string $time)
    {
        $this->setMessage("L'heure (" . ($time == null ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder() . " est invalide.");
    }
    protected function messageInvalideTimeFromInput(string $time)
    {
        $this->setMessage("L'heure (" . ($time == null ? "INCONNUE" : $time) . ") venant du champs " . $this->getPlaceHolder($this->keytimeToCompare) . " est invalide.");
    }
}
