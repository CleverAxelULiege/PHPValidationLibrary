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

    use App\Validation\Validator;

    require(__DIR__ . "/vendor/autoload.php");
    Validator::displayErrorMessages();


    Validator::displayErrorMessages("start_time");
    Validator::displayErrorMessages("end_time");
    ?>
</body>
</html>