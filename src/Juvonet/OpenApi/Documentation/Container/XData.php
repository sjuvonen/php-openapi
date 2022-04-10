<?php

namespace Juvonet\OpenApi\Documentation\Container;

final class XData implements \ArrayAccess, \Countable, \IteratorAggregate, \JsonSerializable
{
    public function __construct(
        private array $data = []
    ) {
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function jsonSerialize(): mixed
    {
        return $this->data ?: null;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->data);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }
}
