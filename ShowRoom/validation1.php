<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Validation\Rules\BelgianNationalNumberRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;

$data = [
    "firstname" => "Billy",
    "lastname" => "Bob",
    "birthdate" => "1942/01/22",
    "national_number" => "42.01.22.051-81",
];

$validationRules = [
    "firstname" => [
        new RequiredRule(),
        new LengthRule(100),
    ],
    "lastname" => [
        new RequiredRule(),
        new LengthRule(100),
    ],
    "birthdate" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsDateRule(date("Y/m/d")),
    ],
    "national_number" => [
        new RequiredRule(),
        new BelgianNationalNumberRule(),
    ]
];

Validator::rawDisplay(new Validator($validationRules, $data));