<?php

namespace App\Validation\Rules;

use ReflectionFunction;
use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

class ExcludeIfRule extends AbstractRuleDependentAnotherInput
{

    public function __construct(string $keyFromAnotherInput, callable $needsToBeExcludedIf)
    {
        parent::__construct($keyFromAnotherInput, $needsToBeExcludedIf);
        $this->setIsKey(true);
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        $reflectionFunc = new ReflectionFunction($this->callback);
        switch (count($reflectionFunc->getParameters())) {
            case 1:
                if ($this->getKey() == $this->getInput()) {
                    if (call_user_func($this->callback, $value)) {
                        $this->setNeedsToBeExcluded(true);
                    }
                } else {
                    if (call_user_func($this->callback, $valueFromAnotherInput)) {
                        $this->setNeedsToBeExcluded(true);
                    }
                }
                break;

            case 2:
                if (call_user_func($this->callback, $value, $valueFromAnotherInput)) {
                    $this->setNeedsToBeExcluded(true);
                }
                break;
        }

        return true;
    }
}
