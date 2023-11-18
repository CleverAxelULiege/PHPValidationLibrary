<?php

namespace App\Validation\Rules\Parent;

use BadMethodCallException;

abstract class AbstractRule
{
    private string $message = "";
    private mixed $value = null;
    private ?string $type = null;
    private ?string $key = null;
    protected int $priority = 1;
    protected const HIGH_PRIORITY = 0;
    protected const MEDIUM_PRIORITY = 1;
    protected  const LOW_PRIORITY = 2;

    public abstract function isRuleValid(): bool;

    public function getPriority()
    {
        return $this->priority;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getKey()
    {
        return $this->key;
    }

    private function setKey(string $key)
    {
        $this->key = $key;
    }

    protected function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function setValueAndKey(mixed $value, string $key)
    {
        $this->setValue($value);
        $this->setKey($key);
    }

    protected function setValue(mixed $value)
    {
        if (is_string($value))
            $value = trim($value);

        $this->value = $value;
    }

    public function getShouldCastValue()
    {
        return is_null($this->type) == false;
    }

    public function getPlaceHolder(?string $placeholder = null)
    {
        if (is_null($placeholder) == false)
            return ":" . $placeholder;

        return ":" . $this->getKey();
    }

    public function getValue($shouldCastValue = false)
    {
        if (is_null($this->type) && $shouldCastValue) {
            throw new BadMethodCallException("The type for the casting isn't set.");
        }

        if ($shouldCastValue) {
            settype($this->value, $this->type);
            return $this->value;
        }

        return $this->value ?? "";
    }

    /**
     * @param string $type Possibles types :
     * - "int"
     * - "float"
     * - "bool"
     * - "string"
     * - "array"
     * - "null"
     */
    protected function setType(string $type)
    {
        if (!in_array($type, ["bool", "float", "int", "string", "array", "null"])) {
            throw new BadMethodCallException("The type can only be one of those : [\"bool\", \"float\", \"int\", \"string\", \"array\", \"null\"]");
        }

        $this->type = $type;
    }

    //à supprimer STATIC
    public static function fromInput(mixed $value)
    {
        return $value ?? null;
    }
}
