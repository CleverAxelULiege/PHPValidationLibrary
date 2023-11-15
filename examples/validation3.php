<?php

require(__DIR__ . "/../vendor/autoload.php");

use App\Validation\Rules\MustBeAfterOrEqualsDateRule;
use App\Validation\Rules\MustBeAfterOrEqualsTimeRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsTimeRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Validator;

$data = [
    "start_date" => "2023/10/31",
    "end_date" => "2023/12/31",
    "start_time" => "08:00",
    "end_time" => "09:00",
];

$validationRules = [
    "start_date" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsDateRule("end_date", true),
    ],
    "end_date" => [
        new NullableRule(),
        new MustBeAfterOrEqualsDateRule("start_date", true),
    ],
    "start_time" => [
        new NullableRule(),
        new MustBeAfterOrEqualsTimeRule("08:00"),
        new MustBeBeforeOrEqualsTimeRule("end_time", true),
    ],
    "end_time" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsTimeRule("20:00"),
        new MustBeAfterOrEqualsTimeRule("start_time", true),
    ]
];

Validator::rawDisplay(new Validator($validationRules, $data));