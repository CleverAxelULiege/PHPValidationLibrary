<?php

namespace App\Validation\Rules;

use App\Helper\StringHelper;
use App\Helper\DateTimeHelper;
use App\Validation\Rules\Parent\AbstractRule;

//https://www.ksz-bcss.fgov.be/sites/default/files/assets/services_et_support/cbss_manual_fr.pdf
//https://www.ibz.rrn.fgov.be/fileadmin/user_upload/fr/dgip/rapports-annuels/2005/rn.pdf
//https://fr.wikipedia.org/wiki/Num%C3%A9ro_de_registre_national
class BelgianNationalNumberRule extends AbstractRule
{

    public function isRuleValid(): bool
    {
        $value = StringHelper::removeCommonsSeparations($this->getValue());
        $this->setMessage("Le numéro de registre national venant du champs " . $this->getPlaceHolder() . " n'est pas valide.");
        
        if (!is_string($value))
            return false;

        if (mb_strlen($value) != 11 || !is_numeric($value)) {
            return false;
        }

        if ($this->doesMonthExist($value)) {
            //20ième siècle
            if($this->isNationalNumberValid($value, false)){
                return true;
            }

            $today = date("Y/m/d");
            //21ième siècle
            if($this->isNationalNumberValid($value, true) && 
                DateTimeHelper::isFirstDateSoonerOrEqualsThanSecond($this->getDateFromNationalNumber($value, true), $today, "Y/m/d")){
                return true;
            }

        } else {
            //20ieme siècle
            if($this->isNationalNumberValid($value, false)){
                return true;
            }

            //21ième siècle
            if($this->isNationalNumberValid($value, true)){
                return true;
            }
        }

        return false;
    }

    private function isNationalNumberValid(string $natNumber, bool $isFromYear2000)
    {
        $orderNumber = substr($natNumber, 6, 3);
        if((int)$orderNumber < 1 || (int)$orderNumber > 998){
            return false;
        }

        $controlNumber = (int)substr($natNumber, 9, 2);
        $birthDateAndOrderNumber = (int)($isFromYear2000 ? "2" . substr($natNumber, 0, 9) : substr($natNumber, 0, 9));

        return (97 -  ($birthDateAndOrderNumber % 97)) == $controlNumber;
        
    }

    /**
     * Recevoir la date du numéro national sous forme de string dans le format Y/m/d
     */
    private function getDateFromNationalNumber(string $natNumber, bool $isFromYear2000) : string{
        $year = $isFromYear2000 ? "20" . substr($natNumber,0 , 2) : substr($natNumber,0 , 2);
        $month = substr($natNumber, 2, 2);
        $day = substr($natNumber, 4, 2);

        return $year . "/" . $month . "/" . $day;
    }

    /**
     * Si une personne ne connait pas sa date de naissance ou s'il y a trop de naissance pour une certaine date,
     * le mois passe à "00"
     */
    private function doesMonthExist(string $natNumber)
    {
        return substr($natNumber, 2, 2) != "00";
    }
}
