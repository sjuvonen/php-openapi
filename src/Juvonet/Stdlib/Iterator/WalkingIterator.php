<?php

namespace Juvonet\Stdlib\Iterator;

/**
 * Applies a function to each item but returns the original value.
 */
class WalkingIterator extends IdentityIterator
{
    private $fn;

    public function __construct(iterable $items, callable $fn)
    {
        parent::__construct($items);

        $this->fn = $fn;
    }

    public function current(): mixed
    {
        $current = parent::current();
        ($this->fn)($current, parent::key());

        return $current;
    }
}
