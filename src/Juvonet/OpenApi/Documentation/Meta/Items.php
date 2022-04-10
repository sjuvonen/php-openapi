<?php

namespace Juvonet\OpenApi\Documentation\Meta;

use Juvonet\OpenApi\Documentation\AbstractSchema;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\Documentation\Extra\Ref;

/**
 * Declares a property to be of type "array" and defines the item schema.
 */
#[
    \Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)
]
final class Items extends AbstractSchema
{
    public function __construct(
        array $properties = [],
        array $x = [],
        array|null $allOf = null,
        array|null $anyOf = null,
        array|null $enum = null,
        array|null $oneOf = null,
        bool|null $nullable = null,
        bool|null $readOnly = null,
        bool|null $required = null,
        bool|null $writeOnly = null,
        float|int|null $maximum = null,
        float|int|null $minimum = null,
        int|null $maxItems = null,
        int|null $maxLength = null,
        int|null $minItems = null,
        int|null $minLength = null,
        mixed $default = null,
        mixed $example = null,
        string|null $description = null,
        string|null $format = null,
        string|null $title = null,
        string|null $type = null,
        AbstractSchema $items = null,
        Property|null $additionalProperties = null,
        Ref|string|null $ref = null,
    ) {
        parent::__construct(
            additionalProperties: $additionalProperties,
            allOf: $allOf,
            anyOf: $anyOf,
            default: $default,
            description: $description,
            enum: $enum,
            example: $example,
            format: $format,
            items: $items,
            maxItems: $maxItems,
            maxLength: $maxLength,
            maximum: $maximum,
            minItems: $minItems,
            minLength: $minLength,
            minimum: $minimum,
            nullable: $nullable,
            oneOf: $oneOf,
            properties: $properties,
            readOnly: $readOnly,
            ref: $ref,
            required: $required,
            writeOnly: $writeOnly,
            x: $x,
            title: $title,
            type: $type,
        );
    }
}
