<?php
declare(strict_types = 1);

namespace App\Api\Domain\Request;


final class RequestEmail
{
    private $value;

    public function __construct(string $value)
    {
        $email = $this->sanitizeEmail($value);
        $this->ensureIsValidEmail($email);

        $this->value = $email;
    }

    private function sanitizeEmail(string $email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('The email <%s> is not a valid email', $email));
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
