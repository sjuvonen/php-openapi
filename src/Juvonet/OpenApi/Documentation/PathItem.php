<?php

namespace Juvonet\OpenApi\Documentation;

final class PathItem
{
    /**
     * {@internal Keep operations sorted by "preferred order" because they will
     *   also appear in the docs in that same order at least with recent versions
     *   of Swagger UI.}}
     */
    public function __construct(
        public string $path,
        public ?string $summary = null,
        public ?string $description = null,
        public ?Operation $get = null,
        public ?Operation $post = null,
        public ?Operation $put = null,
        public ?Operation $delete = null,
        public ?Operation $head = null,
        public ?Operation $patch = null,
        public ?Operation $options = null,
        public ?Operation $servers = null,
        public ?Operation $trace = null,
    ) {
    }

    public function __get(string $propertyName): mixed
    {
        switch ($propertyName) {
            case 'tags':
                $ops = ['get', 'post', 'put', 'delete', 'patch', 'head', 'options', 'servers', 'trace'];

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
