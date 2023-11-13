<?php

namespace App\Validation\Rules;

use App\Helper\DateTimeHelper;
use DateTime;

class MustBeAfterDateRule extends AbstractRuleDateOperation{


    public function isruleValid(): bool
    {
        $value = $this->getValue();
        $this->setMessage("Date au format invalide. Doit être sous chaine de charactères au format " . $this->format);
        if(!is_string($value)){
            return false;
        }

        $this->messageInvalideDate($value);
        if(DateTimeHelper::validateDate($value, $this->format) == false){
            return false;
        }

        $this->messageInvalideDateFromInput($this->dateToCompare);
        if($this->dateToCompare != null && DateTimeHelper::validateDate($this->dateToCompare, $this->format) == false && $this->isFromInput){
            return false;
        }

        if($this->isFromInput){
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard dans le temps que la date que vous avez fournie depuis le champs " . $this->getPlaceHolder($this->keyDateToCompare) . ", dont la date est le " . $this->dateToCompare);
        }else{
            $this->setMessage("La date donnée venant du champs " . $this->getPlaceHolder() . ", " . $value . ", doit être plus tard dans le temps que le " . $this->dateToCompare);
        }
        
        if($this->dateToCompare != null)
            return DateTimeHelper::isFirstDateLaterThanSecond($value, $this->dateToCompare, $this->format);

        return true;
    }
}