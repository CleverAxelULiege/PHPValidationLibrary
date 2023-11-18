<?php

namespace App\Validation\Rules;

use App\Helper\ValueHelper;
use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;
use ReflectionFunction;

class RequiredIfRule extends AbstractRuleDependentAnotherInput{

    private bool $isRequired = false;

    public function __construct(string $keyFromAnotherInput, callable $needsToBeRequiredIf)
    {
        parent::__construct($keyFromAnotherInput, $needsToBeRequiredIf);
        $this->setIsKey(true);
    }

    public function getIsRequired(){
        return $this->isRequired;
    }
    
    public function isRuleValid(): bool
    {
        $this->isRequired = false;
        // $this->setMessage("Le champs, " . $this->getPlaceHolder() . ", est requis car le champs " . $this->getPlaceHolder($this->getInput()) . " est vide.");
        $this->setMessage("Le champs, " . $this->getPlaceHolder() . ", est requis");
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