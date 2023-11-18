<?php

use App\Database\ClinicDatabase;
use App\FactorySearch\SearchFactoryDatabase;
use App\Validation\Rules\ExistRule;
use App\Validation\Rules\InListRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Rules\UniqueRule;
use App\Validation\Validator;

require(__DIR__ . "/../vendor/autoload.php");

// die("died");

$data = [
    "target_audience" => "adult",
    "firstname" => "",
    "lastname" => "Bob",
    "child_firstname" => "Will",
    "child_lastname" => "Saurin"
];

$rules = [
    "target_audience" => [
        new RequiredRule(),
        new InListRule(["adult", "child"])
    ],
    "firstname" => [
        new RequiredIfRule("target_audience", function($targetAud){
            return $targetAud == "adult";
        }),
        new LengthRule(100, 2)
    ]
];
// $data = [
//     "id" => "Billy",
//     "lastname" => "oui"
// ];

// $rules = [
//     "id" => [
//         new ExistRule(new SearchFactoryDatabase(options: [
//             "database" => new ClinicDatabase(),
//             "column" => "lastname",
//             "table" => "clinicians"
//         ]))
//     ],
//     "lastname" => [
//         new UniqueRule(new SearchFactoryDatabase(options: [
//             "database" => new ClinicDatabase(),
//             "column" => "lastname",
//             "table" => "clinicians"
//         ]))
//     ]
// ];

$validator = new Validator($rules, $data);

Validator::rawDisplay($validator);
