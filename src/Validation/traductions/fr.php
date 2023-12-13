<?php
define("PLACEHOLDER", ":placeholder");
define("OTHER_PLACEHOLDER", ":other_placeholder");
return [
    "belgianIbanRule" => [
        "Le numéro de compte IBAN belge venant du champs " . PLACEHOLDER . " n'est pas valide. Vérifiez que les deux premières lettres BE soient en majuscules et respectez les espaces ou n'en mettez pas.",
    ],
    "belgianNationalNumber" => [
        "Le numéro de registre national venant du champs " . PLACEHOLDER . " n'est pas valide."
    ],
    "belgianPhoneNumber" => [
        "Le numéro de téléphone venant du champs " . PLACEHOLDER . " n'est pas valide ou n'est pas belge."
    ],
    "boolean" => [
        "La valeur du champs " . PLACEHOLDER . "  n'est pas la valeur booléenne expectée : :expectedValue.",
        "La valeur du champs " . PLACEHOLDER . "  n'est pas une valeur booléenne correcte."
    ],
    "date" => [
        "La date donnée venant du champs " . PLACEHOLDER . " n'est pas valide."
    ],
    "email" => [
        "L'adresse e-mail du champs " . PLACEHOLDER . " n'est pas valide."
    ],
    "exist" => [
        "La valeur donnée depuis le champs " . PLACEHOLDER . " n'existe pas dans nos données."
    ],
    "float" => [
        "La valeur du champs " . PLACEHOLDER . " n'est pas un nombre ou un nombre à virgule."
    ],
    "inList" => [
        "La valeur passée dans le champs " . PLACEHOLDER . " n'est pas dans la liste prédéfinie donnée : :list",
    ],
    "integer" => [
        "La valeur du champs " . PLACEHOLDER . " n'est pas un nombre entier"
    ],
    "length" => [
        "La donnée venant du champs " . PLACEHOLDER . " n'est ni sous forme de texte, ni sous forme de liste.",
        "La longueur du texte venant du champs " . PLACEHOLDER . " doit être supérieur ou égal à :min.",
        "La longueur du texte venant du champs " . PLACEHOLDER . " doit être inférieur ou égal à :max.",
        "La longueur de votre liste venant du champs " . PLACEHOLDER . " doit être supérieur ou égal à :min.",
        "La longueur de votre liste venant du champs " . PLACEHOLDER . " doit être inférieur ou égal à :max.",
    ],
    "max" => [
        "La valeur du champs " . PLACEHOLDER . " n'est pas un nombre.",
        "La valeur du champs " . PLACEHOLDER . " ne peut pas être plus grande que : :max."
    ],
    "min" => [
        "La valeur du champs " . PLACEHOLDER . " n'est pas un nombre.",
        "La valeur du champs " . PLACEHOLDER . " ne peut pas être plus petite que : :min."
    ],
    "dateOperation" => [
        "La date (:date) venant du champs " . PLACEHOLDER . " est invalide.",
        "Date au format invalide venant du champs " . PLACEHOLDER . ". Elle doit être sous une chaine de charactères au format :format.",
    ],
    "timeOperation" => [
        "L'heure (:time) venant du champs " . PLACEHOLDER . " est invalide.",
        "Heure au format invalide venant du champs " . PLACEHOLDER .". Elle doit être sous une chaine de charactères au format :format."
    ],
    "mustBeAfterDate" => [
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tard dans le temps que la date que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont la date est le :other_date.",
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tard dans le temps que le :other_date."
    ],
    "mustBeAfterOrEqualsDate" => [
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tard ou égal dans le temps que la date que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont la date est le :other_date.",
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tard ou égal dans le temps que le :other_date."
    ],
    "mustBeAfterTimeOrEquals" => [
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tard ou égal dans le temps que l'heure que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont l'heure est :other_time.",
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tard ou égal dans le temps que :other_time"
    ],
    "mustBeAfterTime" => [
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tard dans le temps que l'heure que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont l'heure est :other_time.",
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tard dans le temps que :other_time"
    ],
    "mustBeBeforeDate" => [
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tôt dans le temps que la date que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont la date est le :other_date.",
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tôt dans le temps que le :other_date."
    ],
    "mustBeBeforeDateOrEquals" => [
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tôt ou égal dans le temps que la date que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont la date est le :other_date.",
        "La date donnée (:date) venant du champs " . PLACEHOLDER . " doit être plus tôt ou égal dans le temps que le :other_date."
    ],
    "mustBeBeforeTimeOrEquals" => [
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tôt ou égal dans le temps que l'heure que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont l'heure est :other_time.",
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tôt ou égal dans le temps que :other_time"
    ],
    "mustBeBeforeTime" => [
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tôt dans le temps que l'heure que vous avez fournie depuis le champs " . OTHER_PLACEHOLDER . ", dont l'heure est :other_time.",
        "L'heure donnée (:time) venant du champs " . PLACEHOLDER . " doit être plus tôt dans le temps que :other_time"
    ],
    "required" => [
        "La valeur du champs " . PLACEHOLDER . " est obligatoire et ne peut pas être composée uniquement d'espaces."
    ],
    "time" => [
        "L'heure venant du champs " . PLACEHOLDER . " n'est pas valide."
    ],
    "unique" => [
        "La valeur donnée depuis le champs " . PLACEHOLDER . " existe déjà dans nos données. Choisissez une autre entrée."
    ]
];
