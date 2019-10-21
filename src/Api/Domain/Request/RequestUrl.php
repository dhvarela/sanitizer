<?php
declare(strict_types = 1);

namespace App\Api\Domain\Request;


final class RequestUrl
{
    private $value;

    public function __construct(string $value)
    {
        $url = $this->sanitizeUrl($value);
        $this->ensureIsValidUrl($url);

        $this->value = $url;
    }

    private function sanitizeUrl(string $url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    private function ensureIsValidUrl(string $url): void
    {
        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(sprintf('The url <%s> is not well formatted', $url));
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
