<?php
declare(strict_types=1);

namespace App\Api\Application\Service\Sanitizer;

use App\Api\Domain\Request\RequestArrayOfIntegers;
use App\Api\Domain\Request\RequestArrayOfStrings;
use App\Api\Domain\Request\RequestBoolean;
use App\Api\Domain\Request\RequestDate;
use App\Api\Domain\Request\RequestEmail;
use App\Api\Domain\Request\RequestFloat;
use App\Api\Domain\Request\RequestInt;
use App\Api\Domain\Request\RequestString;
use App\Api\Domain\Request\RequestUrl;
use App\Api\Domain\Request\TypeParamNotAllowed;

class Sanitizer
{
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';
    const TYPE_STRING = 'string';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY_OF_STRINGS = 'array of strings';
    const TYPE_ARRAY_OF_INTEGERS = 'array of integers';
    const TYPE_EMAIL = 'email';
    const TYPE_URL = 'url';
    const TYPE_DATE = 'date';


    public function __construct()
    {
    }

    public function __invoke($data)
    {
        $sanitizedData = array();

        foreach ($data as $item) {
            $sanitizedData[$item['name']] = $this->sanitizeByType($item['type'], $item['value']);
        }

        return $sanitizedData;
    }

    private function sanitizeByType($type, $value)
    {
        $item = null;

        switch ($type) {
            case self::TYPE_INTEGER:
                $item = new RequestInt($value);
                break;
            case self::TYPE_FLOAT:
                $item = new RequestFloat($value);
                break;
            case self::TYPE_STRING:
                $item = new RequestString($value);
                break;
            case self::TYPE_BOOLEAN:
                $item = new RequestBoolean($value);
                break;
            case self::TYPE_ARRAY_OF_STRINGS:
                $item = new RequestArrayOfStrings($value);
                break;
            case self::TYPE_ARRAY_OF_INTEGERS:
                $item = new RequestArrayOfIntegers($value);
                break;
            case self::TYPE_EMAIL:
                $item = new RequestEmail($value);
                break;
            case self::TYPE_URL:
                $item = new RequestUrl($value);
                break;
            case self::TYPE_DATE:
                $item = new RequestDate($value);
                break;
        }

        if ($item === null) {
            TypeParamNotAllowed::throwBecauseOf($type);
        }

        return $item->value();
    }
}