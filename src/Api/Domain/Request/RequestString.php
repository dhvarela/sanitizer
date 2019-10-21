<?php
declare(strict_types = 1);

namespace App\Api\Domain\Request;


final class RequestString
{
    private $value;

    public function __construct(string $value)
    {
        $value = $this->sanitizeString($value);

        $this->value = $value;
    }

    private function sanitizeString(string $value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
