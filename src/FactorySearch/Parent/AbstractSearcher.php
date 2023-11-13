<?php

namespace App\FactorySearch\Parent;

abstract class AbstractSearcher implements SearcherInterface{
    private array $options;
    private ?string $valueToSearch;
    private string $basePath = __DIR__ . "/../../../";
    
    public function __construct(?string $valueToSearch, array &$options)
    {
        $this->options = $options;
        $this->valueToSearch = $valueToSearch;
    }

    protected function getOptions(?string $key = null){
        if(is_null($key)){
            return $this->options;
        }

        return $this->options[$key] ?? null;
    }

    protected function getValueToSearch(){
        return $this->valueToSearch;
    }

    protected function getBasePath(){
        return $this->basePath;
    }
}