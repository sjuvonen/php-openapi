<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

final class NullNormalizer implements NormalizerInterface
{
    public function supports(mixed $node): bool
    {
        if ($node === null) {
            throw new IgnoreValueException();
        }

        return false;
    }

    public function normalize(mixed $node): mixed
    {
        throw new \BadMethodCallException('This method cannot be called.');
    }
}
