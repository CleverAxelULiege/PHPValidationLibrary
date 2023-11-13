<?php

require(__DIR__ . "/vendor/autoload.php");

use App\FactorySearch\Parent\AbstractSearchFactory;
use App\FactorySearch\SearchFactoryCSV;

function testFactory(AbstractSearchFactory $abstractFactory){
    return $abstractFactory->createSearcher()->isSearchSuccessfull();
}

var_dump(testFactory(new SearchFactoryCSV("CHIEN", ["path" => "/csv/data.csv", "column" => "animal"])));

// $data = [
//     ["name", "age", "random", "animal"],
//     ["Bob", 17, "test ,virgule,", "chien"],
//     ["Willy", 34, "\"test guillemet\"", "poisson rouge"],
//     ["Billy", 25, "hello world", "chat"],
// ];

//  $fileStream = fopen(__DIR__ . "/csv/data.csv", 'w');
 
//  foreach ($data as $fields) {
//      fputcsv($fileStream, $fields);
//  }
 
//  fclose($fileStream);

?>