<?php

namespace App\FactorySearch;

use App\FactorySearch\Parent\AbstractSearchFactory;
use App\FactorySearch\Parent\SearcherInterface;

/**
 * Options possibles :
 * 
 *  - "path" => OBLIGATOIRE - Le fichier CSV à aller chercher.
 *  - "column" => OPTIONNEL - La column spécifique à rechercher peut être un numéro ou un nom.
 */
class SearchFactoryCSV extends AbstractSearchFactory{

    public function createSearcher(): SearcherInterface
    {
        return new SearchCSV($this->getValueToSearch(), $this->getOptions());
    }
}