<?php

namespace App\Validation\Rules;

use App\FactorySearch\Parent\AbstractSearchFactory;
use App\Validation\Rules\Parent\AbstractRule;

class ExistRule extends AbstractRule{

    private AbstractSearchFactory $abstractFactory;
    
    public function __construct(AbstractSearchFactory $abstractFactory)
    {
        $this->abstractFactory = $abstractFactory;
    }

    public function isRuleValid(): bool
    {
        $this->setMessage("La valeur donnée depuis le champs " . $this->getPlaceHolder() . " n'existe pas dans nos données.");
        $this->abstractFactory->setValueToSearch($this->getValue());
        return $this->abstractFactory->createSearcher()->isSearchSuccessfull();
    }
}