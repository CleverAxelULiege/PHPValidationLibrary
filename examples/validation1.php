<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Validation\Rules\BelgianNationalNumberRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;
use App\Validation\ValidatorHelper;

$data = [
    "firstname" => "Billy",
    "lastname" => "Bob",
    "national_number" => "42.01.22.051-81",
    "birthdate" => ""
];

$validationRules = [
    "firstname" => [
        new RequiredRule(), //doit être requis si une chaine de charactères est uniquement composée d'espaces il le considérera quand même comme vide.
        new LengthRule(100, 3), 
        //doit avoir au moins une longueur max de 100 et min de 3.
    ],
    "lastname" => [
        new RequiredRule(),
        new LengthRule(100, 3),
    ],
    "birthdate" => [
        new NullableRule(), //peut être NULL/optionnel
        new MustBeBeforeOrEqualsDateRule(dateToCompare: date("Y/m/d"), format: "Y/m/d"), 
        //doit être avant ou égal à aujourd'hui, possibilité de spécifier le format dans le constructeur par défaut à Y/m/d
    ],
    "national_number" => [
        new RequiredRule(),
        new BelgianNationalNumberRule(),
    ]
];

ValidatorHelper::rawDisplay(new Validator($validationRules, $data));
//OUTPUT DONNÉES VALIDES :
// VALIDE

// array(4) {
//   ["firstname"]=>
//   string(5) "Billy"

//   ["lastname"]=>
//   string(3) "Bob"

//   ["birthdate"]=>
//   NULL

//   ["national_number"]=>
//   string(15) "42.01.22.051-81"
// }
