<?php

namespace Juvonet\Stdlib\Iterator;

/**
 * Applies a function to the items.
 */
class TransformIterator extends IdentityIterator
{
    private $fn;

    public function __construct(iterable $iterable, callable $fn)
    {
        parent::__construct($iterable);

        $this->fn = $fn;
    }

    public function current(): mixed
    {
        return ($this->fn)(parent::current(), parent::key());
    }
}
