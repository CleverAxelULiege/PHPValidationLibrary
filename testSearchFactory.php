<?php

require(__DIR__ . "/vendor/autoload.php");

use App\FactorySearch\Parent\AbstractSearchFactory;
use App\FactorySearch\SearchFactoryCSV;

function testFactory(AbstractSearchFactory $abstractFactory){
    return $abstractFactory->createSearcher()->isSearchSuccessfull();
}

var_dump(testFactory(new SearchFactoryCSV("CHIEN", ["path" => "/csv/data.csv", "column" => "animal"])));

?>