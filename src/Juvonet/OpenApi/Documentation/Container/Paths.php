<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\Documentation\PathItem;

final class Paths extends AbstractContainer
{
    public function __construct(
        array $paths = []
    ) {
        parent::__construct($paths, PathItem::class, 'path');
    }

    public function addOperation(Operation $operation): void
    {
        if (!$operation->path) {
            throw new \InvalidArgumentException('Cannot add an operation with empty path.');
        }

        if (!$this->has($operation->path)) {
            $this->add(new PathItem($operation->path));
        }

        $pathItem = $this->get($operation->path);

        if (property_exists($pathItem, $operation->method)) {
            $pathItem->{$operation->method} = $operation;
        } else {
            throw new \OutOfBoundsException("Invalid HTTP verb '{$operation->method}' defined for an operation.");
        }
    }
}
