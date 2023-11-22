<?php

use App\Validation\Validator;
use App\Validation\ValidatorHelper;
use App\Validation\Rules\InListRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Rules\ExcludeIfRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;

require(__DIR__ . "/../vendor/autoload.php");

// die("died");

$data = [
    "target_audience" => "adult",
    "firstname" => "tr",
    "lastname" => "br",
    "child_firstname" => "",
    "child_lastname" => "",
    "birthdate" => "2000/35/01"
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
    ],
    "birthdate" => [
        new NullableRule(), //peut être NULL/optionnel
        new ExcludeIfRule("target_audience", fn($targetAud) => $targetAud == "child"),
        new RequiredIfRule("target_audience", fn($targetAud) => $targetAud == "adult"),
        new MustBeBeforeOrEqualsDateRule(dateToCompare: date("Y/m/d"), format: "Y/m/d"), 
        //doit être avant ou égal à aujourd'hui, possibilité de spécifier le format dans le constructeur par défaut à Y/m/d
    ],
];

$placeHolders = [
    "target_audience" => "public cible"
];

$validator = new Validator($rules, $data, $placeHolders);

ValidatorHelper::rawDisplay($validator);
