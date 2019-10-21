<?php

namespace App\Api\Domain\Request;


final class RequestFloat
{
    private $value;

    public function __construct($value)
    {
        $value = $this->sanitizeFloat($value);
        $this->ensureIsValidFloat($value);

        $this->value = $value;
    }

    private function sanitizeFloat($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    private function ensureIsValidFloat($value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
            throw new \InvalidArgumentException(sprintf('The value <%s> is not a valid float', $value));
        }
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value();
    }
}
