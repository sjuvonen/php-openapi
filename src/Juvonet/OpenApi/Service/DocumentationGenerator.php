<?php

namespace Juvonet\OpenApi\Service;

use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\DocumentationGeneratorInterface;
use Juvonet\OpenApi\LoaderInterface;

final class DocumentationGenerator implements DocumentationGeneratorInterface
{
    public const OPEN_API_VERSION = '3.0.3';

    public function __construct(
        private \Juvonet\OpenApi\LoaderInterface $loader,
        private \Juvonet\OpenApi\SchemaRegistryInterface $schemaRegistry,
        private iterable $processors,
    ) {
    }

    public function generate(): OpenApi
    {
        $openApi = new OpenApi(
            self::OPEN_API_VERSION,
            schemaRegistry: $this->schemaRegistry,
        );

        $this->loader->load($openApi);

        foreach ($this->processors as $processor) {
            $processor($openApi);
        }

        return $openApi;
    }
}
