<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

class EnumNormalizer implements NormalizerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $inner
    ) {
    }

    public function supports(mixed $node): bool
    {
        return $node instanceof \UnitEnum;
    }

    public function normalize(mixed $node): mixed
    {
        return $node->value;
    }
}
