<?php

namespace Juvonet\OpenApi;

final class Utils
{
    private function __construct()
    {
    }

    public static function identifierFromClassName(string $className, ?string $methodName = null): string
    {
        $identifier = $className;
        $identifier = strtolower($identifier);
        $identifier = strtr($identifier, [
            '\\' => '-',
            '__' => 'x-',
        ]);

        if ($methodName) {
            $identifier .= '--' . self::identifierFromClassName($methodName);
        }

        return $identifier;
    }
}
