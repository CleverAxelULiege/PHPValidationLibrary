<?php

use App\Helper\ValueHelper;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\MustBeAfterDateRuleCopy;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;

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

$validationRules = [
    "start_date" => [
        new RequiredRule(),
    ],
    "end_date" => [
        new RequiredRule(),
        new MustBeAfterDateRuleCopy("start_date"),
    ]
];

$data = [
    "start_date" => "2023/10/31",
    "end_date" => "2023/10/22",
];

$validator = new Validator($validationRules, $data);

if ($validator->validate()) {
    echo "<pre>";
    var_dump($validator->getValidatedData());
    echo "</pre>";
} else {
    echo "<pre>";
    print_r($validator->getErrorValidationMessages());
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