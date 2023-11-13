<?php

namespace App\FactorySearch\Parent;

abstract class AbstractSearchFactory {
    
    private ?string $valueToSearch;
    private array $options = [];

    public function __construct(?string $valueToSearch, array $options = [])
    {
        $this->valueToSearch = $valueToSearch;
        $this->options = $options;
    }

    public abstract function createSearcher() : SearcherInterface;

    protected function getOptions(){
        return $this->options;
    }

    protected function getValueToSearch(){
        return $this->valueToSearch;
    }
}