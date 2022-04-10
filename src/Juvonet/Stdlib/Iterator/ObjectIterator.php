<?php

namespace Juvonet\Stdlib\Iterator;

use Traversable;

class ObjectIterator implements \IteratorAggregate
{
    public function __construct(
        private object $object
    ) {
    }

    public function getIterator(): Traversable
    {
        return new KeyValueIterator(
            new GeneratorIterator(
                function (): \Generator {
                    foreach ($this->object as $key => $value) {
                        yield [$key, $value];
                    }
                }
            )
        );
    }
}
