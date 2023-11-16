<?php

namespace App\Validation\Rules;

use App\Validation\Rules\Parent\AbstractRule;
use App\FactorySearch\Parent\AbstractSearchFactory;

class UniqueRule extends AbstractRule{
    private AbstractSearchFactory $abstractFactory;
    
    public function __construct(AbstractSearchFactory $abstractFactory)
    {
        $this->abstractFactory = $abstractFactory;
    }

    public function isRuleValid(): bool
    {
        $this->setMessage("La valeur donnée depuis le champs " . $this->getPlaceHolder() . " existe déjà dans nos données. Choisissez une autre valeur.");
        $this->abstractFactory->setValueToSearch($this->getValue());
        return !$this->abstractFactory->createSearcher()->isSearchSuccessfull();
    }
}