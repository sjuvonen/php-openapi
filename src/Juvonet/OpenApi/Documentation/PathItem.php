<?php

namespace Juvonet\OpenApi\Documentation;

final class PathItem
{
    public function __construct(
        public readonly string $path,
        public ?string $summary = null,
        public ?string $description = null,
        public ?Operation $delete = null,
        public ?Operation $get = null,
        public ?Operation $head = null,
        public ?Operation $options = null,
        public ?Operation $patch = null,
        public ?Operation $post = null,
        public ?Operation $put = null,
        public ?Operation $servers = null,
        public ?Operation $trace = null,
    ) {
    }

    public function __get(string $propertyName): mixed
    {
        switch ($propertyName) {
            case 'tags':
                $ops = ['get', 'post', 'put', 'delete'];

                foreach ($ops as $op) {
                    if ($this->{$op}->tags ?? null) {
                        return $this->{$op}->tags;
                    }
                }

                return [];

                break;

            default:
                throw new \OutOfBoundsException("Trying to access a non-existent property '{$propertyName}'.");
        }
    }
}
