<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Container\Properties;
use Juvonet\OpenApi\Documentation\Container\XData;
use Juvonet\OpenApi\Documentation\Extra\Ref;

abstract class AbstractSchema extends DiscoverableAttribute
{
    public readonly Properties $properties;
    public readonly XData $x;

    public function __construct(
        public array|null $allOf,
        public array|null $anyOf,
        public array|null $enum,
        public array|null $oneOf,
        public bool|null $nullable,
        public bool|null $readOnly,
        public bool|null $required,
        public bool|null $writeOnly,
        public float|int|null $maximum,
        public float|int|null $minimum,
        public int|null $maxItems,
        public int|null $maxLength,
        public int|null $minItems,
        public int|null $minLength,
        public mixed $default,
        public mixed $example,
        public string|null $description,
        public string|null $format,
        public string|null $title,
        public string|null $type,
        public AbstractSchema|null $items,
        public AbstractSchema|null $additionalProperties,

        #[\Juvonet\OpenApi\Serializer\Meta\PropertyName('$ref')]
        public Ref|string|null $ref,

        array $properties,
        array $x,
    ) {
        $this->properties = new Properties($properties);
        $this->x = new XData($x);
    }

    public function __clone(): void
    {
        $this->properties = clone $this->properties;
        $this->x = clone $this->x;

        if ($this->items) {
            $this->items = clone $this->items;
        }

        if ($this->additionalProperties) {
            $this->additionalProperties = clone $this->additionalProperties;
        }

        if (is_object($this->ref)) {
            $this->ref = clone $this->ref;
        }
    }

    public function __get(string $property): mixed
    {
        throw new \RuntimeException("Trying to access non-existent property '{$property}'.'");
    }

    public function __set(string $property, mixed $value): void
    {
        throw new \RuntimeException("Trying to modify non-existent property '{$property}'.'");
    }
}
