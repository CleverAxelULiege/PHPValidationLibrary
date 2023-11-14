<?php

namespace App\Validation;

use LogicException;
use App\Helper\ValueHelper;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;

class Validator
{
    /**
     * @var \App\Validation\Rules\Parent\AbstractRule[][] $validationRulesWithKey
     */
    private array $validationRulesWithKey;
    private array $data;

    private array $errorValidationMessages = [];
    private array $validatedData = [];
    private mixed $validValue = null;

    private bool $didValidationFailed = false;
    private bool $canBeNullable = false;
    private bool $needsToBeExcluded = false;

    /**
     * @param \App\Validation\Rules\Parent\AbstractRule[][] $validationRulesWithKey
     */
    public function __construct(array $validationRulesWithKey, array $data)
    {
        $this->validationRulesWithKey = $validationRulesWithKey;
        $this->data = $data;
    }

    public function validate()
    {
        $this->setAllValuesAndKeys();

        foreach ($this->validationRulesWithKey as $key => $validationRules) {
            $this->testForNullableRuleAndRequiredRuleInSameList($validationRules);
            $this->executeValidationRules($validationRules, $key);
        }

        return !$this->didValidationFailed;
    }

    public function getValidatedData()
    {
        return $this->validatedData;
    }

    public function getErrorValidationMessages()
    {
        return array_map(function ($errorMessage) {
            return array_unique($errorMessage);
        }, $this->errorValidationMessages);
    }

    private function setErrorMessage(string $key, string $message)
    {
        $this->didValidationFailed = true;
        
        if (isset($this->errorValidationMessages[$key])) {
            array_push($this->errorValidationMessages[$key], $message);
        } else {
            $this->errorValidationMessages[$key] = [$message];
        }
    }

    /**
     * @param \App\Validation\Rules\Parent\AbstractRule[] $validationRules
     */
    private function executeValidationRules(array &$validationRules, string $key)
    {
        $this->validValue = null;
        $this->needsToBeExcluded = false;

        foreach ($validationRules as $validationRule) {
            if ($validationRule instanceof AbstractRuleDependentAnotherInput) {
                $this->dependentFromAnotherInput($validationRule, $key);
            } else {
                $this->notDependentFromAnotherInput($validationRule, $key);

            }
        }
        
        if ($this->didValidationFailed == false && $this->needsToBeExcluded == false) {
            if (ValueHelper::isEmpty($this->validValue)) {
                $this->validatedData[$key] = null;
            } else {
                $this->validatedData[$key] = $this->validValue;
            }
        }
    }

    private  function dependentFromAnotherInput(AbstractRuleDependentAnotherInput $validationRule, string $key)
    {
        //ternaire pour savoir si clé d'un tableau assoc ou une valeur
        $valueFromAnotherInput = $validationRule->getIsKey() ? $this->data[$validationRule->getInput()] : $validationRule->getInput();
        $validationRule->setValueFromAnotherInput($valueFromAnotherInput);

        if ($validationRule->isRuleValid() == false) {
            //Si une valeur est Requise (Ex RequiredIfRule) mais que la valeur est vide, la validation a raté.
            if (($validationRule->getIsRequired() && ValueHelper::isEmpty($validationRule->getValue()))) {
                $this->setErrorMessage($key, $validationRule->getMessage());
            }
            else if (ValueHelper::isEmpty($validationRule->getValue()) == false && $validationRule->getIsRequired() == false) {
                $this->setErrorMessage($key, $validationRule->getMessage());
            } 
        } else {
            //une des règles a été validée on sauvegarde la valeur.
            //Si une valeur n'a pas encore été assignée ou si c'est la règle a également pour rôle de cast la valeur on assigne à validValue
            if (is_null($this->validValue) || $validationRule->getShouldCastValue()) {
                $this->validValue = $validationRule->getValue($validationRule->getShouldCastValue());
            }

            //Si a besoin d'être exclu via ExcludeIfRule ou une autre règle
            if ($validationRule->getNeedsToBeExcluded()) {
                $this->needsToBeExcluded = true;
            }
        }

        return false;
    }

    private function notDependentFromAnotherInput(AbstractRule $validationRule, string $key)
    {
        //la règle n'est pas valide
        if ($validationRule->isRuleValid() == false) {
            //si une règle dit que ça peut être NULL mais qu'il y a un input (ou que ça ne peut tout simplement ne pas être NULL), 
            //je considère que la règle a été enfreinte et que la validation pour cette règle a raté. 
            if (($this->canBeNullable && ValueHelper::isEmpty($validationRule->getValue()) == false) || $this->canBeNullable == false) {
                $this->didValidationFailed = true;
                $this->setErrorMessage($key, $validationRule->getMessage());
            } 
        } else {
            //une des règles a été validée on sauvegarde la valeur.
            //Si une valeur n'a pas encore été assignée ou si c'est la règle a également pour rôle de cast la valeur on assigne à validValue
            if (is_null($this->validValue) || $validationRule->getShouldCastValue()) {
                $this->validValue = $validationRule->getValue($validationRule->getShouldCastValue());
            }
        }
    }


    private function setAllValuesAndKeys()
    {
        foreach ($this->validationRulesWithKey as $key => $rules) {
            if (isset($this->data[$key]) == false) {
                $this->data[$key] = null;
            }

            foreach ($rules as $rule) {
                $rule->setValueAndKey($this->data[$key], $key);
            }
        }
    }

    /**
     * @param \App\Validation\Rules\Parent\AbstractRule[] $validationRules
     * @throws LogicException if NullableRule and RequiredRule in same array
     */
    private function testForNullableRuleAndRequiredRuleInSameList(array &$validationRules)
    {
        $isRequired = false;
        $isNullable = false;

        foreach ($validationRules as $validationRule) {
            if ($validationRule instanceof NullableRule)
                $isNullable = true;
            else if ($validationRule instanceof RequiredRule)
                $isRequired = true;

            $this->canBeNullable = $isNullable;

            if ($isRequired && $isNullable) {
                throw new LogicException("You can't have a NullableRule and a RequiredRule in the same list of rules.");
            }
        }

        if($isRequired == false && $isNullable == false){
            $this->canBeNullable = true;
        }
    }

    public static function rawDisplay(Validator $validator){
        if ($validator->validate()) {
            echo "VALIDE <br>";
            echo "<pre>";
            var_dump($validator->getValidatedData());
            echo "</pre>";
        } else {
            echo "NON VALIDE <br>";
            echo "<pre>";
            var_dump($validator->getErrorValidationMessages());
            echo "</pre>";
        }
    }
}
