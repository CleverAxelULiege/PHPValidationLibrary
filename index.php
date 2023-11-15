<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <li><a href="./ShowRoom/validation1.php">Validation 1</a></li>
    </ul>
</body>
</html>

<?php 
use App\Helper\DateTimeHelper;
require(__DIR__ . "/vendor/autoload.php");
DateTimeHelper::addZerosWhenNeeded("Y/m/d", "2023/1/1");
?>