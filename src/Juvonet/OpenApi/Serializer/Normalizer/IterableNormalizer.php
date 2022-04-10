<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

class IterableNormalizer implements NormalizerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $inner
    ) {
    }

    public function supports(mixed $node): bool
    {
        return is_iterable($node);
    }

    public function normalize(mixed $node): mixed
    {
        $normalized = [];
        $indexed = null;

        foreach ($node as $field => $value) {
            if ($indexed === null) {
                $indexed = $field === 0;
            }

            if ($this->inner->supports($value)) {
                $value = $this->inner->normalize($value);

                if ($indexed) {
                    $normalized[] = $value;
                } else {
                    $normalized[$field] = $value;
                }
            }
        }

        if ($normalized) {
            return $normalized;
        } else {
            throw new IgnoreValueException();
        }
    }
}
