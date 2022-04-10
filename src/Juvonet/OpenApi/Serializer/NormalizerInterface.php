<?php

namespace Juvonet\OpenApi\Serializer;

interface NormalizerInterface
{
    public function supports(mixed $node): bool;
    public function normalize(mixed $node): mixed;
}
