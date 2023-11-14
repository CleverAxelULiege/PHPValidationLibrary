<?php

use App\Helper\ValueHelper;
use App\Validation\Rules\ExcludeIfRule;
use App\Validation\Validator;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\MustBeAfterDateRule;
use App\Validation\Rules\MustBeAfterOrEqualsDateRule;
use App\Validation\Rules\MustBeAfterTimeRule;
use App\Validation\Rules\MustBeBeforeDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsTimeRule;
use App\Validation\Rules\MustBeBeforeTimeRule;

require(__DIR__ . "/vendor/autoload.php");

// $validationRules = [
//     "phone_number" => [
//         new NullableRule(),
//         new LengthRule(10, 0),
//         new ExcludeIfRule("phone_number", function($value, $valueFromAnotherInput){
//             return ValueHelper::isEmpty($value);
//         }),
//     ],
//     "another_phone_number" => [
//         new NullableRule(),
//         new RequiredIfRule("phone_number", function($value, $valueFromAnotherInput){
//             return ValueHelper::isEmpty($valueFromAnotherInput);
//         }),
//         new ExcludeIfRule("phone_number", function($value, $valueFromAnotherInput){
//             return ValueHelper::isEmpty($valueFromAnotherInput) == false;
//         }),
//     ],
// ];


// $data = [
//     "phone_number" => "",
//     "another_phone_number" => "0515",
// ];

$validationRules = [
    "start_date" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsDateRule("end_date", true),
    ],
    "end_date" => [
        new NullableRule(),
        new MustBeAfterOrEqualsDateRule("start_date", true),
    ]
];

$data = [
    "start_date" => [1,2,3],
    "end_date" => "2023/10/31"
];

// $validationRules = [
//     "start_time" => [
//         new NullableRule(),
//         new MustBeAfterTimeRule("10:00"),
//         new MustBeBeforeOrEqualsTimeRule("end_time", true),
//     ],
//     "end_time" => [
//         new RequiredRule(),
//         new MustBeBeforeTimeRule("20:00"),
//         new MustBeAfterTimeRule("start_time", true)
//     ]
// ];

// $data = [
//     "start_time" => "blablabla",
//     "end_time" => "17:00"
// ];

$validator = new Validator($validationRules, $data);

if ($validator->validate()) {
    echo "<pre>";
    var_dump($validator->getValidatedData());
    echo "</pre>";
} else {
    echo "<pre>";
    var_dump($validator->getErrorValidationMessages());
    echo "</pre>";
}