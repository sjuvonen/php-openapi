<?php

namespace Juvonet\OpenApi\Util;

use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\Documentation\PathItem;

final class PathItems
{
    private function __construct()
    {
    }

    public static function extractOperations(PathItem|iterable $pathItems): iterable
    {
        if ($pathItems instanceof PathItem) {
            $pathItems = [$pathItems];
        }

        foreach ($pathItems as $pathItem) {
            foreach ($pathItem as $operation) {
                if ($operation instanceof Operation) {
                    yield $operation;
                }
            }
        }
    }
}
