<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

final class ScalarNormalizer implements NormalizerInterface
{
    public function supports(mixed $node): bool
    {
        return is_bool($node) || is_float($node) || is_int($node) || is_string($node);
    }

    public function normalize(mixed $node): mixed
    {
        return $node;
    }
}
