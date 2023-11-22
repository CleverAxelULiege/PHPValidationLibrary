<?php

namespace App\Validation;

use LogicException;
use App\Helper\ValueHelper;
use App\Validation\Rules\ExcludeIfRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\Parent\AbstractRuleDependentAnotherInput;
use App\Validation\Rules\RequiredIfRule;

class Validator extends AbstractValidator
{
    /**
     * @var \App\Validation\Rules\Parent\AbstractRule[][] $validationRules
     */
    private ?string $redirectURL = null;
    private array $errorValidationMessages = [];
    private array $validatedData = [];
    private mixed $validValue = null;

    private bool $didValidationFailed = false;
    private bool $canBeNullable = false;
    private bool $needsToBeExcluded = false;

    private bool $shouldIgnoreOtherRules = false;
    private array $keysToRemoveFromDataWhenRedirecting = [];

    /**
     * @param \App\Validation\Rules\Parent\AbstractRule[][] $validationRules
     */
    public function __construct(array $validationRules, array $data, array $placeholders = null)
    {
        $this->validationRules = $validationRules;
        $this->data = $data;
        $this->placeholders = $placeholders;
    }

    public function validate(): bool
    {
        $this->setAllValuesAndKeys();

        foreach ($this->validationRules as $key => $validationRules) {
            $this->shouldIgnoreOtherRules = false;
            $this->validValue = null;
            $this->needsToBeExcluded = false;

            usort($validationRules, function (AbstractRule $a, AbstractRule $b) {
                return $a->getPriority() - $b->getPriority();
            });

            $this->testForNullableRuleAndRequiredRuleInSameList($validationRules);
            $this->executeValidationRules($validationRules, $key);
        }

        $this->removeCookieOldData();
        $this->removeCookieErrorMessages();

        if ($this->didValidationFailed){
            $this->tryToRedirectOnFail();
            return $this;
        }

        return !$this->didValidationFailed;
    }

    public function getValidatedData(): array
    {
        return $this->validatedData;
    }

    public function getErrorMessages(): array
    {
        return array_map(function ($errorMessage) {
            return array_unique($errorMessage);
        }, $this->errorValidationMessages);
    }

    public function setKeysToRemoveFromDataWhenRedirecting(array $keys)
    {
        $this->keysToRemoveFromDataWhenRedirecting = $keys;
        return $this;
    }

    public function redirectTo(string $url)
    {
        $this->redirectURL = $url;
        return $this;
    }

    private function removeCookieOldData()
    {
        setcookie("old_data", "", [
            "expires" => time() - Validator::COOKIE_TIME,
            "path" => "/",
            "secure" => true,
            "httponly" => true,
            "samesite" => 'strict',
        ]);
    }

    private function addCookieOldData()
    {
        $URI = parse_url($this->redirectURL)["path"];

        setcookie("old_data", json_encode([
            "uri" => str_replace("index.php", "", $URI),
            "old_data" => array_filter($this->data, function ($d) {
                return !in_array($d, $this->keysToRemoveFromDataWhenRedirecting);
            }, ARRAY_FILTER_USE_KEY)
        ], JSON_UNESCAPED_UNICODE), [
            "expires" => 0,
            "path" => "/",
            "secure" => true,
            "httponly" => true,
            "samesite" => 'strict',
        ]);
    }

    private function removeCookieErrorMessages()
    {
        setcookie("error_messages", "", [
            "expires" => time() - Validator::COOKIE_TIME,
            "path" => "/",
            "secure" => true,
            "httponly" => true,
            "samesite" => 'strict',
        ]);
    }

    private function addCookieErrorMessages()
    {
        $URI = parse_url($this->redirectURL)["path"];

        setcookie("error_messages", json_encode([
            "uri" => str_replace("index.php", "", $URI),
            "messages" => $this->getErrorMessages()
        ], JSON_UNESCAPED_UNICODE), [
            "expires" => 0,
            "path" => "/",
            "secure" => true,
            "httponly" => true,
            "samesite" => 'strict',
        ]);
    }

    private function tryToRedirectOnFail()
    {
        if ($this->redirectURL != null) {
            $this->addCookieErrorMessages();
            $this->addCookieOldData();

            header("Location :" . $this->redirectURL, response_code: 303);
            exit;
        }
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
            if (!($validationRule instanceof RequiredIfRule && $this->checkIfNeedToBeRequiredDynamically($validationRule) || $validationRule instanceof ExcludeIfRule)) {
                $message = $this->replacePlaceHolder($key, $validationRule->getMessage(), $validationRule->getPlaceHolder());

                if ($validationRule->getIsKey())
                    $message = $this->replacePlaceHolder($validationRule->getInput(), $message, $validationRule->getPlaceHolder($validationRule->getInput()));

                if (($this->canBeNullable && ValueHelper::isEmpty($validationRule->getValue()) == false) || $this->canBeNullable == false) {
                    $this->setErrorMessage($key, $message);
                }
            }
        } else {
            //une des règles a été validée on sauvegarde la valeur.
            //Si une valeur n'a pas encore été assignée ou si c'est la règle a également pour rôle de cast la valeur on assigne à validValue
            if (is_null($this->validValue) || $validationRule->getShouldCastValue()) {
                $this->validValue = $validationRule->getValue($validationRule->getShouldCastValue());
            }

            if ($validationRule instanceof ExcludeIfRule) {
                $this->needsToBeExcluded = true;
            }
        }

        return false;
    }

    private function notDependentFromAnotherInput(AbstractRule $validationRule, string $key)
    {
        //la règle n'est pas valide
        if ($validationRule->isRuleValid() == false) {
            if (!$this->shouldIgnoreOtherRules) {
                //si une règle dit que ça peut être NULL mais qu'il y a un input (ou que ça ne peut tout simplement ne pas être NULL), 
                //je considère que la règle a été enfreinte et que la validation pour cette règle a raté.
                if (($this->canBeNullable && ValueHelper::isEmpty($validationRule->getValue()) == false) || $this->canBeNullable == false) {
                    $this->setErrorMessage($key, $this->replacePlaceHolder($key, $validationRule->getMessage(), $validationRule->getPlaceHolder()));
                }
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
        foreach ($this->validationRules as $key => $rules) {
            if (isset($this->data[$key]) == false) {
                $this->data[$key] = null;
            }

            foreach ($rules as $rule) {
                $rule->setValueAndKey($this->data[$key], $key);
            }
        }
    }

    private function replacePlaceHolder(string $key, string $message, string $placeholder)
    {
        if (isset($this->placeholders[$key])) {
            $message = str_replace($placeholder, $this->placeholders[$key], $message);
        }

        return $message;
    }

    private function checkIfNeedToBeRequiredDynamically(RequiredIfRule $rule)
    {
        if ($rule->getIsRequired()) {
            $this->canBeNullable = false;
            return false;
        } else {
            $this->shouldIgnoreOtherRules = true;
            return true;
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
        $isRequirefIf = false;

        foreach ($validationRules as $validationRule) {
            if ($validationRule instanceof NullableRule)
                $isNullable = true;
            else if ($validationRule instanceof RequiredRule)
                $isRequired = true;
            else if ($validationRule instanceof RequiredIfRule)
                $isRequirefIf = true;


            $this->canBeNullable = $isNullable;

            if ($isRequired && $isNullable) {
                throw new LogicException("You can't have a NullableRule and a RequiredRule in the same list of rules.");
            }

            if ($isRequired && $isRequirefIf) {
                throw new LogicException("You can't have a RequiredIfRule and a RequiredRule in the same list of rules.");
            }
        }

        //sera par défaut à NullableRule si RequiredRule ou NullableRule n'est pas précisé.
        if ($isRequired == false && $isNullable == false) {
            $this->canBeNullable = true;
        }
    }
}
