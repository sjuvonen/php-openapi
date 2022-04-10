<?php

namespace Juvonet\Stdlib\Iterator;

/**
 * Iterates over item, yielding only those that pass the filter.
 */
class FilterIterator implements \IteratorAggregate
{
    private $inner;

    public function __construct(iterable $iterable, \Closure $filter)
    {
        $this->inner = $iterable;
        $this->fn = $filter;
    }

    public function getIterator(): \Traversable
    {
        return new GeneratorIterator(function () {
            foreach ($this->inner as $key => $value) {
                if (($this->fn)($value, $key)) {
                    yield $value;
                }
            }
        });
    }
}
