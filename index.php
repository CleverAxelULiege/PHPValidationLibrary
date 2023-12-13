<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <ul>
        <li><a href="./examples/validation1.php">Validation 1</a></li>
        <li><a href="./examples/validation2.php">Validation 2</a></li>
        <li><a href="./examples/validation3.php">Validation 3</a></li>
        <li><a href="./examples/validation4.php">Validation 4</a></li>
    </ul>

    <?php

use App\Validation\Rules\LengthRule;
use App\Validation\Rules\RequiredRule;
    use App\Validation\Validator;
use App\Validation\ValidatorHelper;

    require(__DIR__ . "/vendor/autoload.php");

    $data = [
        "name" => "billybobobobobo",
    ];

    $rules = [
        "name" => [
            new RequiredRule(),
            new LengthRule(9, 3)
        ]
    ];

    $placeholders = [
        "name" => "nom",
    ];

    ValidatorHelper::rawDisplay(new Validator($rules, $data, "en", $placeholders));

    ?>
</body>

</html>