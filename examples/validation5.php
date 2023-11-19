<?php

use App\Validation\Rules\ExcludeIfRule;
use App\Validation\Rules\InListRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;

require(__DIR__ . "/../vendor/autoload.php");

// die("died");

$data = [
    "target_audience" => "gneu",
    "firstname" => "tr",
    "lastname" => "br",
    "child_firstname" => "",
    "child_lastname" => ""
];

$rules = [
    "target_audience" => [
        new RequiredRule(),
        new InListRule(["adult", "child"])
    ],
    "firstname" => [
        new ExcludeIfRule("target_audience", fn($targetAud) => $targetAud == "child"),
        new RequiredIfRule("target_audience", fn($targetAud) => $targetAud == "adult"),
        new LengthRule(100, 2)
    ],
    "child_firstname" => [        
        new ExcludeIfRule("target_audience", fn($targetAud) => $targetAud == "adult"),
        new RequiredIfRule("target_audience", fn($targetAud) => $targetAud == "child"),
        new LengthRule(100, 2)
    ],
    "lastname" => [
        new ExcludeIfRule("target_audience", fn($targetAud) => $targetAud == "child"),
        new RequiredIfRule("target_audience", fn($targetAud) => $targetAud == "adult"),
        new LengthRule(100, 2)
    ],
    "child_lastname" => [
        new ExcludeIfRule("target_audience", fn($targetAud) => $targetAud == "adult"),
        new RequiredIfRule("target_audience", fn($targetAud) => $targetAud == "child"),
        new LengthRule(100, 2)
    ]
];

$placeHolders = [
    "target_audience" => "public cible"
];

$validator = new Validator($rules, $data, $placeHolders);

Validator::rawDisplay($validator);
