<?php


namespace App\Api\Domain\Request;

use RuntimeException;

class TypeParamNotAllowed extends RuntimeException
{
    public static function throwBecauseOf($name)
    {
        throw new self(sprintf("The filter type param %s is not allowed", $name));
    }
}