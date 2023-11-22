<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Validation\Rules\MustBeAfterOrEqualsDateRule;
use App\Validation\Rules\MustBeAfterOrEqualsTimeRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsTimeRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Validator;
use App\Validation\ValidatorHelper;

$data = [
    "start_date" => "2023/10/31",
    "end_date" => "2023/12/31",
    "start_time" => "10:00",
    "end_time" => "09:00",
];

$validationRules = [
    "start_date" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsDateRule("end_date", isKey: true), //start_date doit commencer avant ou être égal à end_date et ici le booléen "isKey" lui précise
        //que c'est une valeur venant d'une autre clef et qu'il doit aller la chercher et non entrée en brut.
    ],
    "end_date" => [
        new NullableRule(),
        new MustBeAfterOrEqualsDateRule("start_date", isKey: true),
    ],
    "start_time" => [
        new NullableRule(),
        new MustBeAfterOrEqualsTimeRule("08:00", isKey: false), //ici le temps doit commencer au moins à partir de 08:00. Je lui dis que c'est une valeur "hardcodée" 
        //en mettant le isKey à FALSE et qu'il n'est pas obligé d'aller rechercher une valeur en fonction d'une quelconque clef.
        new MustBeBeforeOrEqualsTimeRule("end_time", isKey: true),
    ],
    "end_time" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsTimeRule("20:00"), //Par défaut isKey est à FALSE donc on peut ne pas lui spécifier lorsqu'une valeur est "hardcodée".
        new MustBeAfterOrEqualsTimeRule("start_time", isKey: true),
    ]
];

$placeholder = [
    "start_time" => "\"heure de début\"",
    "end_time" => "\"heure de fin\""
];

ValidatorHelper::rawDisplay(new Validator($validationRules, $data, $placeholder));
//OUTPUT DONNÉES VALIDES :
// VALIDE

// array(4) {
//   ["start_date"]=>
//   string(10) "2023/10/31"

//   ["end_date"]=>
//   string(10) "2023/12/31"

//   ["start_time"]=>
//   string(5) "08:00"

//   ["end_time"]=>
//   string(5) "09:00"
// }
