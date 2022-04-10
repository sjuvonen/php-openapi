<?php

namespace Juvonet\OpenApi\Documentation\Extra;

use Juvonet\OpenApi\Documentation\Container\Headers;
use Juvonet\OpenApi\Documentation\Container\Parameters;
use Juvonet\OpenApi\Documentation\Container\Responses;
use Juvonet\OpenApi\Documentation\Container\Schemas;
use Juvonet\OpenApi\Documentation\Container\SecuritySchemes;
use Juvonet\OpenApi\Documentation\Schema;

final class Components
{
    public readonly Headers $headers;
    public readonly Parameters $parameters;
    public readonly Responses $responses;
    public readonly Schemas $schemas;
    public readonly SecuritySchemes $securitySchemes;

    public function __construct(
        array $headers = [],
        array $parameters = [],
        array $responses = [],
        array $schemas = [],
        array $securitySchemes = [],
    ) {
        $this->headers = new Headers($headers);
        $this->parameters = new Parameters($parameters);
        $this->responses = new Responses($responses);
        $this->schemas = new Schemas($schemas);
        $this->securitySchemes = new SecuritySchemes($securitySchemes);
    }
}
