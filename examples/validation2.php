<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Helper\ValueHelper;
use App\Validation\Rules\BelgianPhoneNumberRule;
use App\Validation\Rules\BooleanRule;
use App\Validation\Rules\ExcludeIfRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;
use App\Validation\ValidatorHelper;

$data = [
    "phone_number" => "",
    "other_phone_number" => "0123456789",
    "checkbox_must_accept_condition" => "true",
];

$validationRules = [
    "phone_number" => [
        new NullableRule(),
        new BelgianPhoneNumberRule(),
        new ExcludeIfRule("phone_number", function($ownValue){
            return ValueHelper::isEmpty($ownValue); //sera exclu des données validées si sa propre valeur est vide ou si uniquement composée d'espaces
        })
    ],
    "other_phone_number" => [
        new NullableRule(),
        new RequiredIfRule("phone_number", function($valuePhoneNumber){
            return ValueHelper::isEmpty($valuePhoneNumber); //Devra être requis si aucun "phone_number" n'a été précisé
        }),
        new ExcludeIfRule("phone_number", function($valuePhoneNumber){
            return ValueHelper::isEmpty($valuePhoneNumber) == false; //sera exclu des données validées si "phone_number" a été précisé
        }),
    ],
    "checkbox_must_accept_condition" => [
        new RequiredRule(), //devra être cochée
        new BooleanRule(),
    ],
    "checkbox_not_checked" => [
        new BooleanRule(), 
        //Si une checkbox n'existe pas dans le $_POST ou autre part car non checkée (On utilise if(isset...) pour voir si une checkbox est ou n'est pas cochée en PHP) 
        //cette règle permet quand même de créer une valeur FALSE.
    ]
];

ValidatorHelper::rawDisplay(new Validator($validationRules, $_POST));
//OUTPUT DONNÉES VALIDES :
// VALIDE

// array(3) {
//   ["other_phone_number"]=>
//   string(10) "0123456789"

//   ["checkbox_must_accept_condition"]=>
//   bool(true)

//   ["checkbox_not_checked"]=>
//   bool(false)
// }
