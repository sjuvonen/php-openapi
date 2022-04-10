<?php

namespace Juvonet\OpenApi\Service;

use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\SerializerInterface;

final class Serializer implements SerializerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $normalizer
    ) {
    }

    public function serialize(array|object|null $node): string
    {
        $normalized = $this->normalize($node);
        $encoded = $this->encode($normalized);

        return $encoded;
    }

    private function normalize(array|object|null $node): ?array
    {
        return $this->normalizer->normalize($node);
    }

    private function encode(mixed $normalized): string
    {
        return json_encode($normalized, JSON_PRETTY_PRINT);
    }
}
