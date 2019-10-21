<?php
declare(strict_types = 1);

namespace App\Api\Domain\Request;


final class RequestArrayOfIntegers
{
    private $value;

    public function __construct(array $value)
    {
        $sanitizedValues = array();

        foreach ($value as $aValue) {
            $sanitizedValues[] = new RequestInt($aValue);
        }

        $this->setValue(...$sanitizedValues);
    }

    private function setValue(RequestInt ...$value)
    {
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }
}
