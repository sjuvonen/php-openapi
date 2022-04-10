<?php

namespace Juvonet\Stdlib\Iterator;

/**
 * Operates on a list of (key, value) pairs, essentially transforming a map-like
 * array structure into a proper [$key => $value] map.
 */
class KeyValueIterator extends IdentityIterator
{
    public function key(): mixed
    {
        return parent::current()[0];
    }

    public function current(): mixed
    {
        return parent::current()[1];
    }
}
