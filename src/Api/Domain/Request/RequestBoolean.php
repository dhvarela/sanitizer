<?php

namespace App\Api\Domain\Request;


final class RequestBoolean
{
    private $value;

    public function __construct($value)
    {
        $this->ensureIsValidBool($value);

        $this->value = $value;
    }

    private function ensureIsValidBool($value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            throw new \InvalidArgumentException(sprintf('The value <%s> is not a valid boolean', $value));
        }
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value() ? 'true' : 'false';
    }
}
