<?php

namespace Juvonet\OpenApi\Util;

use ReflectionType;
use ReflectionUnionType;

final class Reflection
{
    private function __construct()
    {
    }

    public static function hasType(?ReflectionType $reflectionType, string $typeName): bool
    {
        if (!$reflectionType) {
            return false;
        }

        if ($reflectionType instanceof ReflectionUnionType) {
            foreach ($reflectionType->getTypes() as $subType) {
                if (static::hasType($subType, $typeName)) {
                    return true;
                }
            }

            return false;
        } else {
            if ($reflectionType->getName() === $typeName) {
                return true;
            }

            if (is_a($reflectionType->getName(), $typeName, true)) {
                return true;
            }

            return false;
        }
    }
}
