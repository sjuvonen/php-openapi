<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Serializer\Exception\IgnoreValueException;
use Juvonet\OpenApi\Serializer\NormalizerInterface;

class ObjectNormalizer implements NormalizerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $inner
    ) {
    }

    public function supports(mixed $node): bool
    {
        return is_object($node);
    }

    public function normalize(mixed $node): mixed
    {
        $normalized = null;

        foreach ($node as $field => $value) {
            try {
                if ($this->inner->supports($value)) {
                    $field = $this->getFieldName($node, $field);
                    $normalized[$field] = $this->inner->normalize($value);
                }
            } catch (IgnoreValueException) {
                // Exclude this node; pass.
            }
        }

        return $normalized;
    }

    private function getFieldName(object $node, string $propertyName): string
    {
        $rprop = new \ReflectionProperty($node, $propertyName);
        $attributes = $rprop->getAttributes('Juvonet\OpenApi\Serializer\Meta\PropertyName');

        foreach ($attributes as $attribute) {
            return $attribute->getArguments()[0] ?? $propertyName;
        }

        return $propertyName;
    }
}
