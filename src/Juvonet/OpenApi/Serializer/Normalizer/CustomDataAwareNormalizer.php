<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Documentation as OA;
use Juvonet\OpenApi\Serializer\NormalizerInterface;
use WeakMap;

/**
 * Decorates the common normalizer chain and inspects for the custom data "x"
 * property.
 */
final class CustomDataAwareNormalizer implements NormalizerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $inner
    ) {
    }

    public function supports(mixed $node): bool
    {
        return $this->inner->supports($node);
    }

    public function normalize(mixed $node): mixed
    {
        $normalized = $this->inner->normalize($node);

        if (isset($normalized['x'])) {
            foreach ($normalized['x'] as $key => $value) {
                $normalized["x-{$key}"] = $value;
            }

            unset($normalized['x']);
        }

        return $normalized;
    }
}
