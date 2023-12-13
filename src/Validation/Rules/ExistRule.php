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
        $this->setMessageDetails("exist", 0, [
            ":placeholder" => $this->getPlaceHolder()
        ]);
        $this->abstractFactory->setValueToSearch($this->getValue());
        return $this->abstractFactory->createSearcher()->isSearchSuccessfull();
    }
}