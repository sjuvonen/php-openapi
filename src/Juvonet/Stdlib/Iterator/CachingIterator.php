<?php

namespace Framework\Stdlib\Iterator;

class CachingIterator implements \IteratorAggregate
{
    private $inner;
    private $keyFn;
    private $cache;

    public function __construct(iterable $iterable, \Closure $keyFn = null)
    {
        $this->inner = $iterable;
        $this->keyFn = $keyFn;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->doCache());
    }

    private function doCache(): array
    {
        if ($this->cache === null) {
            $this->cache = [];

            foreach ($this->inner as $key => $value) {
                if ($this->keyFn) {
                    $key = ($this->keyFn)($key);
                }

                $this->cache[$key] = $value;
            }
        }

        return $this->cache;
    }
}
