<?php

namespace Juvonet\OpenApi;

final class Context
{
    public function __construct(
        public readonly string $file,
        public readonly ?string $class = null,
        public readonly ?string $method = null,
        public readonly ?string $property = null,
    ) {
    }

    public function with(string $property, mixed $value): Context
    {
        $values = get_object_vars($this);
        $values[$property] = $value;

        return new Context(...$values);
    }
}
