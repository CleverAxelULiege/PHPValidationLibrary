<?php

namespace App\FactorySearch\Parent;

abstract class AbstractSearchFactory {
    
    private ?string $valueToSearch;
    private array $options = [];

    public function __construct(?string $valueToSearch = null, array $options = [])
    {
        $this->valueToSearch = $valueToSearch;
        $this->options = $options;
    }

    
    public abstract function createSearcher() : SearcherInterface;
    
    public function getOptions(){
        return $this->options;
    }
    
    public function getValueToSearch(){
        return $this->valueToSearch;
    }

    public function setValueToSearch(string $valueToSearch){
        $this->valueToSearch = $valueToSearch;
        return $this;
    }

    public function setOptions(array $options){
        $this->options = $options;
        return $this;
    }
}