<?php
declare(strict_types = 1);

namespace App\Api\Domain\Request;


final class RequestArrayOfStrings
{
    private $value;

    public function __construct(array $value)
    {
        $sanitizedValues = array();

        foreach ($value as $aValue) {
            $sanitizedValues[] = new RequestString($aValue);
        }

        $this->setValue(...$sanitizedValues);
    }

    private function setValue(RequestString ...$value)
    {
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }
}
