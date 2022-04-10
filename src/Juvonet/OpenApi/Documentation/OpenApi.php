<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Container\Paths;
use Juvonet\OpenApi\Documentation\Extra\Components;
use Juvonet\OpenApi\Documentation\Extra\Info;
use Juvonet\OpenApi\Documentation\Extra\Ref;

final class OpenApi
{
    public function __construct(
        public ?string $openapi = null,
        public readonly Info $info = new Info(),
        public readonly Paths $paths = new Paths(),
        public readonly Components $components = new Components(),
        \Juvonet\OpenApi\SchemaRegistryInterface $schemaRegistry = null,
    ) {
        if ($schemaRegistry) {
            $this->components->schemas->setRegistry($schemaRegistry);
        }
    }
}
