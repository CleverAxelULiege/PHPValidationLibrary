<?php

namespace App\FactorySearch;

use App\FactorySearch\Parent\AbstractSearchFactory;
use App\FactorySearch\Parent\SearcherInterface;

/** 
 *  Options possibles :
 * 
 * - "database" => OBLIGATOIRE - La base de donnée à utiliser doit être une instance de App\Database\Parent\Database.
 * - "column" => OBLIGATOIRE - La column à utiliser.
 * - "table" => OBLIGATOIRE - La table à utiliser.
 */
class SearchFactoryDatabase extends AbstractSearchFactory{
    public function createSearcher(): SearcherInterface
    {
        return new SearchDatabase($this->getValueToSearch(), $this->getOptions());
    }
}