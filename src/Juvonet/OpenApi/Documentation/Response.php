<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Container\Headers;
use Juvonet\OpenApi\Documentation\Container\MediaTypes;
use Juvonet\OpenApi\Documentation\Container\Parameters;
use Juvonet\OpenApi\Documentation\Extra\Ref;

final class Response
{
    public readonly Headers $headers;
    public readonly MediaTypes $content;

    public function __construct(
        public int $response,
        public array $links = [],
        public string|null $description = null,
        #[\Juvonet\OpenApi\Serializer\Meta\PropertyName('$ref')]
        public Ref|string|null $ref = null,
        array $headers = [],
        MediaType|array $content = [],
    ) {
        $this->headers = new Headers($headers);
        $this->content = new MediaTypes($content);
    }
}
