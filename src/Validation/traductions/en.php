<?php
define("PLACEHOLDER", ":placeholder");
define("OTHER_PLACEHOLDER", ":other_placeholder");
return [
    "belgianIbanRule" => [
        "The Belgian IBAN account number coming from the field " . PLACEHOLDER . " is not valid. Please check that the first two letters BE are capitalized and respect the spaces or leave them blank.",
    ],
    "belgianNationalNumber" => [
        "The national register number from the field " . PLACEHOLDER . " field is invalid."
    ],
    "belgianPhoneNumber" => [
        "The phone number coming from field " . PLACEHOLDER . " is invalid or not Belgian."
    ],
    "boolean" => [
        "The value of field " . PLACEHOLDER . " is not the expected boolean value : :expectedValue.",
        "The value of the field " . PLACEHOLDER . " is not a correct Boolean value."
    ],
    "date" => [
        "The given date coming from the field " . PLACEHOLDER . " field is invalid."
    ],
    "email" => [
        "The email address from field " . PLACEHOLDER . " is invalid."
    ],
    "exist" => [
        "The value given from field " . PLACEHOLDER . " does not exist in our data."
    ],
    "float" => [
        "The value of the field " . PLACEHOLDER . " is not a number or a decimal point."
    ],
    "inList" => [
        "The value passed in the field " . PLACEHOLDER . " is not in the given predefined list: :list",
    ],
    "integer" => [
        "The value in the field " . PLACEHOLDER . " is not an integer"
    ],
    "length" => [
        "The data coming from the field " . PLACEHOLDER . " field is neither text nor list",
        "The length of the text coming from field " . PLACEHOLDER . " must be greater than or equal to :min.",
        "The length of the text coming from the field ". PLACEHOLDER . " must be less than or equal to :max.",
        "The length of your list coming from the field ". PLACEHOLDER . " must be greater than or equal to :min.",
        "The length of your list coming from the field ". PLACEHOLDER . "must be less than or equal to :max.",
    ],
    "max" => [
        "The value of the field " . PLACEHOLDER . " is not a number.",
        "The value of the field " . PLACEHOLDER . " cannot be greater than : :max."
    ],
    "min" => [
        "The value of the field " . PLACEHOLDER . " is not a number.",
        "The value of the field " . PLACEHOLDER . " cannot be smaller than : :min."
    ],
    "dateOperation" => [
        "The date (:date) coming from the field " . PLACEHOLDER . "is invalid.",
        "Invalid date format from field " . PLACEHOLDER . ". It must be in string format :format.",
    ],
    "timeOperation" => [
        "The time (:time) coming from the field " . PLACEHOLDER . " field is invalid.",
        "Invalid time format from field " . PLACEHOLDER .". It must be in string format :format."
    ],
    "mustBeAfterDate" => [
        "The given date (:date) coming from the field " . PLACEHOLDER . " field must be later in time than the date you provided from the " . OTHER_PLACEHOLDER . ", whose date is :other_date.",
        "The given date (:date) coming from the field " . PLACEHOLDER . " must be later in time than the :other_date."
    ],
    "mustBeAfterOrEqualsDate" => [
        "The given date (:date) coming from the field " . PLACEHOLDER . " field must be later than or equal to the date you supplied from the " . OTHER_PLACEHOLDER . ", whose date is :other_date.",
        "The given date (:date) coming from the field " . PLACEHOLDER . " must be later than or equal to the :other_date."
    ],
    "mustBeAfterTimeOrEquals" => [
        "The given time (:time) from the field " . PLACEHOLDER . " must be later than or equal to the time you supplied from field " . OTHER_PLACEHOLDER . ", whose time is :other_time.",
        "The given time (:time) coming from the field " . PLACEHOLDER . " must be later than or equal to :other_time."
    ],
    "mustBeAfterTime" => [
        "The given time (:time) coming from the field " . PLACEHOLDER . " must be later in time than the time you supplied from the " . OTHER_PLACEHOLDER . ", whose time is :other_time.",
        "The given time (:time) from the field ". PLACEHOLDER . " must be later in time than :other_time."
    ],
    "mustBeforeDate" => [
        "The given date (:date) coming from the field " . PLACEHOLDER . " field must be earlier in time than the date you supplied from the " . OTHER_PLACEHOLDER . ", whose date is :other_date.",
        "The given date (:date) coming from the field " . PLACEHOLDER . " must be earlier in time than the :other_date."
    ],
    "mustBeforeDateOrEquals" => [
        "The given date (:date) coming from the field " . PLACEHOLDER . " field must be earlier or equal in time to the date you supplied from the " . OTHER_PLACEHOLDER . ", whose date is :other_date.",
        "The given date (:date) coming from the field " . PLACEHOLDER . " must be earlier or equal in time to the :other_date."
    ],
    "mustBeforeTimeOrEquals" => [
        "The given time (:time) coming from the field " . PLACEHOLDER . " must be earlier than or equal to the time you supplied from the " . OTHER_PLACEHOLDER . ", whose time is :other_time.",
        "The given time (:time) coming from the field " . PLACEHOLDER . " must be earlier than or equal to :other_time."
    ],
    "mustBeforeTime" => [
        "The given time (:time) from the field " . PLACEHOLDER . " must be earlier in time than the time you supplied from the " . OTHER_PLACEHOLDER . ", whose time is :other_time.",
        "The given time (:time) from the field ". PLACEHOLDER . " must be earlier in time than :other_time."
    ],
    "required" => [
        "The value of the field " . PLACEHOLDER . " is mandatory and cannot be composed of spaces only."
    ],
    "time" => [
        "Time from the field" . PLACEHOLDER . " field is invalid."
    ],
    "unique" => [
        "The value given from field " . PLACEHOLDER . " already exists in our data. Choose another entry."
    ]
];
