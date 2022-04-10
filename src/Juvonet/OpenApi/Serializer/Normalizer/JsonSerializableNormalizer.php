<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\NormalizerInterface;

final class JsonSerializableNormalizer implements NormalizerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $inner
    ) {
    }

    public function supports(mixed $node): bool
    {
        return $node instanceof \JsonSerializable;
    }

    public function normalize(mixed $node): mixed
    {
        $normalized = $node->jsonSerialize();
        $normalized = $this->inner->normalize($normalized);

        return $normalized;
    }
}
