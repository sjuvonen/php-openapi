<?php

namespace Juvonet\OpenApi\Iterator;

use IteratorIterator;

final class KeyFromFieldIterator extends IteratorIterator
{
    public const ARRAY_INDEX = 'array_index';
    public const OBJECT_METHOD = 'object_method';
    public const OBJECT_PROPERTY = 'object_property';

    private $keyMode;
    private $keyMethod;

    public function __construct(
        iterable $data,
        private string $keyField,
    ) {
        parent::__construct(is_array($data) ? new \ArrayIterator($data) : $data);
    }

    public function key(): mixed
    {
        $data = $this->current();

        if ($this->keyMode === null) {
            switch (true) {
                case is_array($data):
                    $this->keyMode = self::ARRAY_INDEX;
                    break;

                case is_object($data) && property_exists($data, $this->keyField):
                    $this->keyMode = self::OBJECT_PROPERTY;
                    break;

                default:
                    if (!is_object($data)) {
                        throw new \RuntimeException('Items must be either arrays or objects.');
                    }

                    $methodName = 'get' . ucfirst($this->keyField);

                    if (!method_exists($data, $methodName)) {
                        throw new \RuntimeException("Object value has no public property or accessor for '{$this->keyField}'.");
                    }

                    $this->keyMethod = $methodName;

                    break;
            }

            match ($this->keyMode) {
                self::ARRAY_INDEX => $data[$this->keyField],
                self::OBJECT_METHOD => $data->{$this->keyMethod}(),
                self::OBJECT_PROPERTY => $data->{$this->keyField},
            };
        }
    }
}
