<?php

namespace Juvonet\Stdlib\Iterator;

use Traversable;
use WeakMap;

/**
 * Iterates through an object tree, yielding only object values.
 */
class RecursiveObjectIterator implements \IteratorAggregate
{
    private WeakMap $visited;

    public function __construct(
        private object $object
    ) {
        $this->visited = new WeakMap();
    }

    public function getIterator(): Traversable
    {
        $this->visited[$this->object] = true;

        yield from $this->iterate($this->object);
    }

    private function iterate(object $object): Traversable
    {
        return new GeneratorIterator(
            function () use ($object): \Generator {
                $root = new ObjectIterator($object);

                foreach ($root as $key => $value) {
                    if (is_array($value)) {
                        yield from $value;

                        continue;
                    }

                    if (is_object($value)) {
                        if ($this->visited->offsetExists($value)) {
                            continue;
                        }

                        $this->visited[$value] = true;

                        yield $key => $value;
                        yield from $this->iterate($value);

                        continue;
                    }
                }
            }
        );
    }
}
