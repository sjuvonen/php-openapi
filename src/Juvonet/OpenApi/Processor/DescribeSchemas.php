<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\OpenApi;

class DescribeSchemas
{
    public function __construct(
        private \Juvonet\OpenApi\SchemaDescriberInterface $schemaDescriber,
    ) {
    }

    public function __invoke(OpenApi $api): void
    {
        foreach ($api->components->schemas as $schema) {
            if ($this->schemaDescriber->supports($schema)) {
                $this->schemaDescriber->describe($schema);
            }
        }
    }
}
