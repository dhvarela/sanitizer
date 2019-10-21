<?php

namespace App\Api\Domain\Request;


final class RequestInt
{
    private $value;

    public function __construct($value)
    {
        $value = $this->sanitizeInt($value);
        $this->ensureIsValidInt($value);

        $this->value = $value;
    }

    private function sanitizeInt($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    private function ensureIsValidInt($value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(sprintf('The value <%s> is not a valid integer', $value));
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value();
    }
}
