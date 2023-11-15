<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Validation\Rules\BelgianNationalNumberRule;
use App\Validation\Rules\FloatRule;
use App\Validation\Rules\IntegerRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\MinRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;

$data = [
    "integer" => "50",
    "float" => "50.5",
];

$validationRules = [
    "integer" => [
        new RequiredRule(),
        new IntegerRule(), //devra être obligatoirement un INT
        new MinRule(10.5), //MinRule peut prendre un FLOAT ou un INT en tant que paramètre
    ],
    "float" => [
        new RequiredRule(),
        new FloatRule(), //devra être obligatoirement un FLOAT ou un INT
        new MinRule(50),
    ]
];

Validator::rawDisplay(new Validator($validationRules, $data));

//On remarquera qu'avec les règles il cast automatiquement les valeurs de chaine de charactères en INT ou en FLOAT

//OUTPUT DONNÉES VALIDES :
// VALIDE

// array(2) {
//   ["integer"]=>
//   int(50)

//   ["float"]=>
//   float(50.5)
// }

