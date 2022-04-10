<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Container\MediaTypes;
use Juvonet\OpenApi\Documentation\Extra\Ref;

final class RequestBody
{
    public MediaTypes $content;

    public function __construct(
        public bool|null $required = null,
        public string|null $description = null,
        public string|null $requestBody = null,
        #[\Juvonet\OpenApi\Serializer\Meta\PropertyName('$ref')]
        public Ref|string|null $ref = null,
        MediaType|array $content = [],
    ) {
        $this->content = new MediaTypes($content);
    }
}
