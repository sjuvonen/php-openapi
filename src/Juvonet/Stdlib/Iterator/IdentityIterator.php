<?php

namespace Juvonet\Stdlib\Iterator;

use ArrayIterator;
use IteratorIterator;

/**
 * Convenience class for other iterators to build upon.
 *
 * Wraps any iterable (not just Traversable) with an Iterator interface.
 */
class IdentityIterator extends IteratorIterator
{
    public function __construct(iterable $items)
    {
        if (is_array($items)) {
            $items = new ArrayIterator($items);
        }

        parent::__construct($items);
    }
}
