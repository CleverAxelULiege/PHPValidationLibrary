<?php

namespace App\Validation;

use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use LogicException;

class Validator
{
    /**
     * @var \App\Validation\Rules\AbstractRule[][] $validationRulesWithKey
     */
    private array $validationRulesWithKey;
    private array $data;

    private array $errorValidationMessages = [];
    private array $validatedData = [];
    private bool $didValidationFailed = false;
    private bool $canBeNullable = false;

    /**
     * @param \App\Validation\Rules\AbstractRule[][] $validationRulesWithKey
     */
    public function __construct(array $validationRulesWithKey, array $data)
    {
        $this->validationRulesWithKey = $validationRulesWithKey;
        $this->data = $data;
    }

    public function validate()
    {
        foreach ($this->validationRulesWithKey as $key => $validationRules) {
            $this->testForNullableRuleAndRequiredRuleInSameList($validationRules);

            if(isset($this->data[$key]) == false){
                $this->data[$key] = null;
            }

            $this->executeValidationRules($validationRules, $key);
        }
        // echo "<pre>";
        // print_r(array_map(function($errorMessage){
        //     return array_unique($errorMessage);
        // },$this->errorValidationMessages));
        // echo "</pre>";
        // echo "<br>--------------------------------<br>";
        // echo "<pre>";
        // var_dump($this->validatedData);
        // echo "</pre>";
        return !$this->didValidationFailed;
    }

    public function getValidatedData(){
        return $this->validatedData;
    }

    public function getErrorValidationMessages(){
        return array_map(function($errorMessage){
            return array_unique($errorMessage);
        },$this->errorValidationMessages);
    }

    private function setErrorMessage(string $key, string $message)
    {
        if (isset($this->errorValidationMessages[$key])) {
            array_push($this->errorValidationMessages[$key], $message);
        } else {
            $this->errorValidationMessages[$key] = [$message];
        }
    }

    /**
     * @param \App\Validation\Rules\AbstractRule[] $validationRules
     */
    private function executeValidationRules(array &$validationRules, string $key)
    {
        $validValue = null;
        foreach ($validationRules as $validationRule) {
            //la règle n'est pas valide
            if ($validationRule($this->data[$key], $key) == false) {
                //si une règle dit que ça peut être NULL mais qu'il y a un input, je considère que la règle a été enfreinte et que la validation
                //pour cette règle a raté. Sinon si ça peut être NULL et que l'input est vide, je casse la boucle et considère la règle comme non enfreinte.
                if (($this->canBeNullable && $this->isDataEmpty($this->data[$key]) == false) || $this->canBeNullable == false) {
                    $this->didValidationFailed = true;
                    $this->setErrorMessage($key, $validationRule->getMessage());
                } else if ($this->canBeNullable && $this->isDataEmpty($this->data[$key])) {
                    break;
                }
            } else {
                //une des règles a été validée on sauvegarde la valeur.
                //Si une valeur n'a pas encore été assignée ou si c'est la règle a également pour rôle de cast la valeur on assigne à validValue
                if (is_null($validValue) || $validationRule->getShouldCastValue()) {
                    $validValue = $validationRule->getValue($validationRule->getShouldCastValue());
                }
            }
        }
        if ($this->didValidationFailed == false) {
            //toujours le cas pour si la règle est Nullable et qu'il n'y a rien dedans
            // if ($this->isDataEmpty($this->data[$key]) ||  (is_string($validValue) && trim($validValue) == "")) {
            if ($this->isDataEmpty($validValue)) {
                $this->validatedData[$key] = null;
            } else {
                $this->validatedData[$key] = $validValue;
            }
        }
    }

    /**
     * @param \App\Validation\Rules\AbstractRule[] $validationRules
     * @throws LogicException if NullableRule and RequiredRule in same array
     */
    private function testForNullableRuleAndRequiredRuleInSameList(array &$validationRules)
    {
        $isRequiredIsNullable = [
            "isRequired" => false,
            "isNullable" => false,
        ];
        foreach ($validationRules as $validationRule) {
            if ($validationRule instanceof NullableRule)
                $isRequiredIsNullable["isNullable"] = true;
            else if ($validationRule instanceof RequiredRule)
                $isRequiredIsNullable["isRequired"] = true;

            $this->canBeNullable = $isRequiredIsNullable["isNullable"];

            if ($isRequiredIsNullable["isRequired"] && $isRequiredIsNullable["isNullable"]) {
                throw new LogicException("You can't have a NullableRule and a RequiredRule in the same list of rules.");
            }
        }
    }

    private function isDataEmpty($value)
    {
        if (isset($value) == false || is_null($value)) {
            return true;
        }

        if (is_string($value) && strlen(trim($value)) == 0) {
            return true;
        }

        if (is_array($value) && count($value) == 0) {
            return true;
        }

        return false;
    }
}
