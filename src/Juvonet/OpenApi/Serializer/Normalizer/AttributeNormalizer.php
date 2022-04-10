<?php

namespace Juvonet\OpenApi\Serializer\Normalizer;

use Juvonet\OpenApi\Documentation as OA;
use Juvonet\OpenApi\Serializer\NormalizerInterface;
use WeakMap;

final class AttributeNormalizer implements NormalizerInterface
{
    private WeakMap $visited;

    public function __construct(
        private \Juvonet\OpenApi\Serializer\NormalizerInterface $inner
    ) {
        $this->visited = new WeakMap();
    }

    public function supports(mixed $node): bool
    {
        if (!is_object($node)) {
            return false;
        }

        if ($this->visited->offsetExists($node)) {
            return false;
        }

        if ($node instanceof OA\Header) {
            return true;
        }

        if ($node instanceof OA\MediaType) {
            return true;
        }

        if ($node instanceof OA\Operation) {
            return true;
        }

        if ($node instanceof OA\Property) {
            return true;
        }

        if ($node instanceof OA\Response) {
            return true;
        }

        if ($node instanceof OA\Schema) {
            return true;
        }

        return false;
    }

    public function normalize(mixed $node): mixed
    {
        $this->visited[$node] = true;

        $normalized = $this->inner->normalize($node);

        switch (true) {
            case $node instanceof OA\Header:
                unset($normalized['header']);
                break;

            case $node instanceof OA\MediaType:
                unset($normalized['mediaType']);
                break;

            case $node instanceof OA\Operation:
                unset($normalized['path']);
                break;

            case $node instanceof OA\Property:
                unset($normalized['property']);
                break;

            case $node instanceof OA\Response:
                unset($normalized['response']);
                break;

            case $node instanceof OA\Schema:
                unset($normalized['schema']);
                break;
        }

        unset($this->visited[$node]);

        return $normalized;
    }
}
