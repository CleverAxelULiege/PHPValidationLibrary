<?php

namespace App\Validation;

abstract class AbstractValidator
{
    protected array $validationRules;
    protected array $data;
    protected ?array $placeholders;
    protected const COOKIE_TIME = 900;

    public abstract function validate(): bool;
    public abstract function getValidatedData(): array;
    public abstract function getErrorMessages(): array;
}
