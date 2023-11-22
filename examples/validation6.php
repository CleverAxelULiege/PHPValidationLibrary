<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Validation\Rules\LengthRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;

$data = [
    "username" => "Billy",
    "password" => "123456789",
];

$validationRules = [
    "username" => [
        new RequiredRule(),
        new LengthRule(100, 3), 
    ],
    "password" => [
        new RequiredRule(),
        new LengthRule(100, 8),
    ]
];

$validator = new Validator($validationRules, $data);

$data = $validator
        ->redirectTo("/form.php")
        ->setKeysToRemoveFromDataWhenRedirecting(["password"])
        ->validate()
        ->getValidatedData();
