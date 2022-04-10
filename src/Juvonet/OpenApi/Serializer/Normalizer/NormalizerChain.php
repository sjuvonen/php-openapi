<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

class NormalizerChain implements NormalizerInterface
{
    public function __construct(
        private iterable $normalizers
    ) {
    }

    public function supports(mixed $node): bool
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($node)) {
                return true;
            }
        }

        return false;
    }

    public function normalize(mixed $node): mixed
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($node)) {
                return $normalizer->normalize($node);
            }
        }

        throw new \UnexpectedValueException('Passed value cannot be processed by this normalizer.');
    }
}
