<?php

require __DIR__ . "/vendor/autoload.php";

use App\Validation\Rules\AbstractRule;
use App\Validation\Rules\BelgianNationalNumberRule;
use App\Validation\Rules\BelgianPhoneNumberRule;
use App\Validation\Rules\EmailRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\MustBeAfterDateRule;
use App\Validation\Rules\MustBeAfterOrEqualsTimeRule;
use App\Validation\Rules\MustBeAfterTimeRule;
use App\Validation\Rules\MustBeBeforeDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsTimeRule;
use App\Validation\Rules\MustBeBeforeTimeRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;

$validationRules = [
    "lastname" => [
        new RequiredRule(),
        new LengthRule(64, 2)
    ],
    "firstname" => [
        new RequiredRule(),
        new LengthRule(64, 2)
    ],
    "birthdate" => [
        new NullableRule(),
        new MustBeBeforeOrEqualsDateRule(date("Y/m/d"))
    ],
    "phone_number" => [
        new RequiredRule(),
        new BelgianPhoneNumberRule(),
    ],
    "email" => [
        new RequiredRule(),
        new EmailRule(),
    ],
    "national_number" => [
        new RequiredRule(),
        new BelgianNationalNumberRule(),
    ],
    "start_time" => [
        new RequiredRule(),
        new MustBeAfterOrEqualsTimeRule("08:00"),
        new MustBeBeforeTimeRule(AbstractRule::fromInput($_POST["end_time"]), true, "end_time")
    ],
    "end_time" => [
        new RequiredRule(),
        new MustBeBeforeOrEqualsTimeRule("17:30"),
        new MustBeAfterTimeRule(AbstractRule::fromInput($_POST["start_time"]), true, "start_time")
    ],
    "start_date" => [
        new RequiredRule(),
        new MustBeBeforeDateRule(date('Y/m/d', strtotime('+2 years'))),
        new MustBeBeforeDateRule(AbstractRule::fromInput($_POST["end_date"]), true, "end_date"),
    ],
    "end_date" => [
        new NullableRule(),
        new MustBeBeforeDateRule(date('Y/m/d', strtotime('+2 years'))),
        new MustBeAfterDateRule(AbstractRule::fromInput($_POST["start_date"]), true, "start_date"),
    ]

];

$validator = new Validator($validationRules, $_POST);

if ($validator->validate()) {
    echo "<pre>";
    print_r($validator->getValidatedData());
    echo "</pre>";
} else {
    echo "<pre>";
    print_r($validator->getErrorValidationMessages());
    echo "</pre>";
}