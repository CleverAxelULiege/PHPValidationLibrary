<?php

namespace App\FactorySearch;

use App\FactorySearch\Parent\AbstractSearchFactory;
use App\FactorySearch\Parent\SearcherInterface;

class SearchFactoryCSV extends AbstractSearchFactory{

    public function createSearcher(): SearcherInterface
    {
        return new SearchCSV($this->getValueToSearch(), $this->getOptions());
    }
}