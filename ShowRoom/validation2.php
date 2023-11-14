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

$data = [
    "phone_number" => "",
    "other_phone_number" => "test",
    "checkbox_must_accept_condition" => true,
];

$validationRules = [
    "phone_number" => [
        new NullableRule(),
        new BelgianPhoneNumberRule(),
    ],
    "other_phone_number" => [
        new NullableRule(),
        new RequiredIfRule("phone_number", function($valueOtherPhoneNumber, $valuePhoneNumber){
            return ValueHelper::isEmpty($valuePhoneNumber);
        }),
        new ExcludeIfRule("phone_number", function($valueOtherPhoneNumber, $valuePhoneNumber){
            return ValueHelper::isEmpty($valuePhoneNumber) == false;
        }),
    ],
    "checkbox_must_accept_condition" => [
        new RequiredRule(),
        new BooleanRule(),
    ],
    "checkbox_not_checked" => [
        new BooleanRule(), //Si une checkbox n'existe pas dans le $_POST ou autre part car non checkée cette règle permet quand même de créer une "fausse" valeur FALSE.
    ]
];

Validator::rawDisplay(new Validator($validationRules, $data));