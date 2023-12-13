<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;
use App\Validation\Rules\RuleException;

class LengthRule extends AbstractRule
{
    private ?int $maxLength;
    private int $minLength;

    public function __construct(?int $maxLength = null, int $minLength = 0)
    {
        $this->maxLength = $maxLength;
        $this->minLength = $minLength;
        $this->tryThrowRuleException();
    }

    public function isRuleValid(): bool
    {
        $placeholderMin = ":min";
        $placeholderMax = ":max";

        $value = $this->getValue();

        if(is_string($value) == false && is_array($value) == false){
            $this->setMessageDetails("length", 0, [
                AbstractRule::PLACEHOLDER => $this->getPlaceHolder()
            ]);
            return false;
        }

        if (is_string($value)) {
            $stringLength = mb_strlen($value);

            if($stringLength < $this->minLength){
                $this->setMessageDetails("length", 1, [
                    AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                    $placeholderMin => $this->minLength
                ]);
                return false;
            }
            
            if($this->checkIfMaxLengthNotRespected($stringLength)){
                $this->setMessageDetails("length", 2, [
                    AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                    $placeholderMax => $this->maxLength
                ]);
                return false;
            }

        } else if (is_array($value)) {
            $arrayLength = count($value);
            if($arrayLength < $this->minLength){
                $this->setMessageDetails("length", 3, [
                    AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                    $placeholderMin => $this->minLength
                ]);
                return false;
            }

            if($this->checkIfMaxLengthNotRespected($arrayLength)){
                $this->setMessageDetails("length", 4, [
                    AbstractRule::PLACEHOLDER => $this->getPlaceHolder(),
                    $placeholderMax => $this->maxLength
                ]);
                return false;
            }
        }

        return true;
    }

    protected function tryThrowRuleException()
    {
        $value = $this->getValue();
        if(isset($value) == false){
            throw new RuleException("No value passed");
        }

        if($this->minLength < 0) {
            throw new RuleException("The property minLength can't be less than 0");
        }

        if($this->minLength > $this->maxLength){
            throw new RuleException("The property minLength can't be superior than the property maxLength");
        }
    }

    private function checkIfMaxLengthNotRespected(int $length){
        return is_null($this->maxLength) == false && $length > $this->maxLength;
    }
}
