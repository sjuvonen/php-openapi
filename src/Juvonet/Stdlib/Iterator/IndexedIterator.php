<?php

namespace Juvonet\Stdlib\Iterator;

/**
 * Iterates through values while enforcing 0...n indexing.
 */
class IndexedIterator extends IdentityIterator
{
    public function rewind(): void
    {
        parent::rewind();

        $this->i = 0;
    }

    public function next(): void
    {
        parent::next();

        $this->i++;
    }

    public function key(): mixed
    {
        return $this->i;
    }
}
