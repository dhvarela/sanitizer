<?php
declare(strict_types = 1);

namespace App\Api\Domain\Request;


final class RequestDate
{
    private $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidDate($value);

        $this->value = $value;
    }

    private function ensureIsValidDate(string $date)
    {
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            throw new \InvalidArgumentException(sprintf('The date <%s> is not a valid date', $date));
        }
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
