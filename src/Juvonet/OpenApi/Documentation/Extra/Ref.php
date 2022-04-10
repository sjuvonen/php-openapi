<?php

namespace Juvonet\OpenApi\Documentation\Extra;

final class Ref
{
    public function __construct(
        public readonly ?string $class = null,
        public readonly ?array $context = null,
    ) {
    }

    /**
     * Produces a hash that can be used for looking up the matching schema.
     */
    public function hash(): string
    {
        if ($this->context) {
            $context = $this->context;

            ksort($context);

            $context = serialize($context);
        }

        return sha1($this->class . ($context ?? ''));
    }
}
