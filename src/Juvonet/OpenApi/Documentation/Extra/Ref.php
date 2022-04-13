<?php

namespace Juvonet\OpenApi\Documentation\Extra;

final class Ref
{
    public function __construct(
        public readonly ?string $class = null,
        public readonly ?array $options = null,
    ) {
    }

    /**
     * Produces a hash that can be used for looking up the matching schema.
     */
    public function hash(): string
    {
        if ($this->options) {
            $options = $this->options;

            ksort($options);

            $options = serialize($options);
        }

        return sha1($this->class . ($options ?? ''));
    }
}
