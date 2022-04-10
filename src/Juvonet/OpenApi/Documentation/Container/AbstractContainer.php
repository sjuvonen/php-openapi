<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Countable;
use Iterator;
use IteratorAggregate;
use JsonSerializable;

abstract class AbstractContainer implements Countable, IteratorAggregate, JsonSerializable
{
    private array $items;

    public function __construct(
        array|object $items,
        private string $className,
        private string|null $keyField = null,
    ) {
        $this->mergeItems($items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function jsonSerialize(): mixed
    {
        return $this->items ?: null;
    }

    public function getIterator(): Iterator
    {
        return new \ArrayIterator($this->items);
    }

    public function add(object $item): void
    {
        $this->assertValidItem($item);

        $key = $this->keyField === null ? count($this->items) : $item->{$this->keyField};
        $this->items[$key] = $item;
    }

    public function has(mixed $key): bool
    {
        return isset($this->items[$key]);
    }

    public function get(mixed $key): object|null
    {
        return $this->items[$key] ?? null;
    }

    public function remove(string $key): void
    {
        unset($this->items[$key]);
    }

    private function mergeItems(array|object $items): void
    {
        $this->items = [];

        if (is_object($items)) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    private function assertValidItem(object $item): void
    {
        if (!$item instanceof $this->className) {
            $self = get_class($this);
            $argumentType = get_class($item);

            throw new \InvalidArgumentException("Items passed to {$self} must be instances of {$this->className}, got {$argumentType} instead.");
        }
    }
}
