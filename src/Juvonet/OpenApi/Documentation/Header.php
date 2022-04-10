<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Extra\Ref;

final class Header
{
    public function __construct(
        public readonly string $header,
        public bool|null $deprecated = null,
        public bool|null $allowEmptyValue = null,
        public string|null $description = null,
        #[\Juvonet\OpenApi\Serializer\Meta\PropertyName('$ref')]
        public Ref|string|null $ref = null,
        public Schema|null $schema = null,
    ) {
    }
}
