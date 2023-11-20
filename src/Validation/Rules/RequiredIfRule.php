<?php

namespace App\Validation\Rules;

use ReflectionFunction;
use App\Helper\ValueHelper;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

class RequiredIfRule extends AbstractRuleDependentAnotherInput{

    private bool $isRequired = false;

    public function __construct(string $keyFromAnotherInput, callable $needsToBeRequiredIf)
    {
        $this->priority = AbstractRule::HIGH_PRIORITY;
        parent::__construct($keyFromAnotherInput, $needsToBeRequiredIf);
        $this->setIsKey(true);
    }

    public function getIsRequired(){
        return $this->isRequired;
    }
    
    public function isRuleValid(): bool
    {
        $this->isRequired = false;
        $this->setMessage("La valeur du champs " . $this->getPlaceHolder() . " est obligatoire et ne peut pas être composée uniquement d'espaces.");
        $value = $this->getValue();
        $valueFromAnotherInput = $this->getValueFromAnotherInput();

        $reflectionFunc = new ReflectionFunction($this->callback);

        switch(count($reflectionFunc->getParameters())){
            case 1:
                if($this->getKey() == $this->getInput()){
                    $this->isRequired = call_user_func($this->callback, $value);
                } else {
                    $this->isRequired = call_user_func($this->callback, $valueFromAnotherInput);
                }
            break;

            case 2:
                $this->isRequired = call_user_func($this->callback, $value, $valueFromAnotherInput);
            break;
        }
        
        return $this->isRequired && !ValueHelper::isEmpty($value);
    }
}