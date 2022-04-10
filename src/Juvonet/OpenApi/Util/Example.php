<?php

namespace Juvonet\OpenApi\Util;

final class Example
{
    private function __construct()
    {
    }

    public static function of(string $type, mixed $condition = 0)
    {
        switch ($type) {
            case 'date':
                return sprintf('%d-01-01', date('Y'));

            case 'date-time':
                return sprintf('%d-01-01T12:00:00Z', date('Y'));

            case 'integer':
                return [1001, 5090][$condition] ?? rand(2000, 3000);

            case 'string':
                return 'foobar';

            default:
                return null;
        }
    }
}
