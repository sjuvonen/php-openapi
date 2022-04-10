<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Context;
use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

final class ContextNormalizer implements NormalizerInterface
{
    public function supports(mixed $node): bool
    {
        if ($node instanceof Context) {
            throw new IgnoreValueException();
        }

        return false;
    }

    public function normalize(mixed $node): mixed
    {
        throw new \BadMethodCallException('This method cannot be called.');
    }
}
