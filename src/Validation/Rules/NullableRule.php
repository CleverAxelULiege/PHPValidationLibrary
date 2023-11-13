<?php

namespace App\Validation\Rules;

/**
 * La valeur peut être optionnel et renverra null. Mais l'entrée ne doit rien avoir dedans ou ne pas exister.
 */
class NullableRule extends AbstractRule{
    public function isRuleValid(): bool
    {
        return true;
    }
}