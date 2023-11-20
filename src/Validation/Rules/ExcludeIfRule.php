<?php

namespace App\Validation\Rules;

use ReflectionFunction;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

class ExcludeIfRule extends AbstractRuleDependentAnotherInput
{

    public function __construct(string $keyFromAnotherInput, callable $needsToBeExcludedIf)
    {
        $this->priority = AbstractRule::HIGH_PRIORITY;
        parent::__construct($keyFromAnotherInput, $needsToBeExcludedIf);
        $this->setIsKey(true);
    }

    public function isRuleValid(): bool
    {
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();
        $shouldExclude = false;
        $reflectionFunc = new ReflectionFunction($this->callback);
        switch (count($reflectionFunc->getParameters())) {
            case 1:
                if ($this->getKey() == $this->getInput()) {
                    $shouldExclude = call_user_func($this->callback, $value);
                } else {
                    $shouldExclude = call_user_func($this->callback, $valueFromAnotherInput);
                }
                break;

            case 2:
                $shouldExclude = call_user_func($this->callback, $value, $valueFromAnotherInput);
                break;
        }

        return $shouldExclude;
    }
}
