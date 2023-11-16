<?php

use App\Database\ClinicDatabase;
use App\FactorySearch\SearchFactoryDatabase;
use App\Validation\Rules\ExistRule;
use App\Validation\Rules\UniqueRule;
use App\Validation\Validator;

require(__DIR__ . "/../vendor/autoload.php");

$data = [
    "id" => "Billy",
    "lastname" => "oui"
];

$rules = [
    "id" => [
        new ExistRule(new SearchFactoryDatabase(options: [
            "database" => new ClinicDatabase(),
            "column" => "lastname",
            "table" => "clinicians"
        ]))
    ],
    "lastname" => [
        new UniqueRule(new SearchFactoryDatabase(options: [
            "database" => new ClinicDatabase(),
            "column" => "lastname",
            "table" => "clinicians"
        ]))
    ]
];

$validator = new Validator($rules, $data);

Validator::rawDisplay($validator);
