<?php

namespace Juvonet\Stdlib\Iterator;

/**
 * Maps a generator function to an iterator.
 *
 * Makes re-using generator functions as iterators easy.
 */
class GeneratorIterator implements \IteratorAggregate
{
    private $factory;

    public function __construct(\Closure $generatorFactory)
    {
        $this->factory = $generatorFactory;
    }

    public function getIterator(): \Iterator
    {
        return new \IteratorIterator(($this->factory)());
    }
}
