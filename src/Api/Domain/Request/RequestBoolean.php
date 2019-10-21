<?php

namespace App\Api\Domain\Request;


final class RequestBoolean
{
    private $value;

    public function __construct($value)
    {
        $value = $this->sanitizeBoolean($value);

        $this->value = $value;
    }

    private function sanitizeBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
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
