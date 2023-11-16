<?php

use App\Database\ClinicDatabase;
use App\FactorySearch\Parent\AbstractSearchFactory;
use App\FactorySearch\SearchDatabase;
use App\FactorySearch\SearchFactoryDatabase;

require(__DIR__ . "/vendor/autoload.php");

// $clinicDb = new ClinicDatabase();

// var_dump($clinicDb->getTables());
// $stmt = $clinicDb->run("select ? from clinicians where id = ?", ["lastname", 2]);

// while($row = $stmt->fetch()){
//     var_dump($row);
//     echo "<br>";
// }

function testFactory(AbstractSearchFactory $abstractFactory){
    return $abstractFactory->createSearcher()->isSearchSuccessfull();
}

var_dump(testFactory(new SearchFactoryDatabase("30", [
    "database" => new ClinicDatabase(),
    "column" => "id",
    "table" => "clinicians",
])));