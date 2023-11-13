<?php

use App\Helper\ValueHelper;
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
//     ],
//     "another_phone_number" => [
//         new NullableRule(),
//         new RequiredIfRule("phone_number", function($value, $valueFromAnotherInput){
//             return ValueHelper::isEmpty($valueFromAnotherInput);
//         }, "Le champs blablabla est requis par rapport à ça")
//     ],
// ];


// $data = [
//     "phone_number" => "test",
//     "another_phone_number" => "coucou",
// ];

// $validationRules = [
//     "start_date" => [
//         new NullableRule(),
//         new MustBeBeforeOrEqualsDateRule("end_date", true),
//     ],
//     "end_date" => [
//         new NullableRule(),
//         new MustBeAfterOrEqualsDateRule("start_date", true),
//     ]
// ];

// $data = [
//     "start_date" => "2023/10/31",
//     "end_date" => "2023/10/31"
// ];

$validationRules = [
    "start_time" => [
        new NullableRule(),
        new MustBeAfterTimeRule("10:00"),
        new MustBeBeforeOrEqualsTimeRule("end_time", true),
    ],
    "end_time" => [
        new NullableRule(),
    ]
];

$data = [
    "start_time" => "15:00",
    "end_time" => null
];

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

// class TestBidon{

//     public mixed $value = ";";
    
//     public function setTest(){
//         $this->value = "not empty";
//         return $this;
//     }
// }

// $arrayTest = [((new TestBidon())->setTest() ?? "lol")];

// var_dump($arrayTest);