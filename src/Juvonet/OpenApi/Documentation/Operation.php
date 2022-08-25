<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Container\Parameters;
use Juvonet\OpenApi\Documentation\Container\Responses;
use Juvonet\OpenApi\Documentation\Container\XData;

class Operation extends DiscoverableAttribute
{
    public readonly Parameters $parameters;
    public readonly Responses $responses;
    public readonly XData $x;

    /**
     * Attribute name for resolving the HTTP method for an operation.
     *
     * NOTE: This attribute is not instantiable.
     */
    private const HTTP_VERB_ATTRIBUTE = 'Juvonet\OpenApi\Documentation\Meta\HttpMethod';

    public function __construct(
        public string $path,
        public ?string $method = null,
        public ?string $operationId = null,
        public ?string $summary = null,
        public ?string $description = null,
        public array $tags = [],
        public ?RequestBody $requestBody = null,
        Response|array $responses = [],
        array $parameters = [],
        array $x = [],
    ) {
        $this->initializeMethod();

        $this->parameters = new Parameters($parameters);
        $this->responses = new Responses($responses);
        $this->x = new XData($x);
    }

    private function initializeMethod(): void
    {
        /**
         * Deduce HTTP method from the class name.
         */
        if (!isset($this->method)) {
            $rclass = new \ReflectionClass($this);
            $attributes = $rclass->getAttributes(self::HTTP_VERB_ATTRIBUTE);

            foreach ($attributes as $attribute) {
                $this->method = ($attribute->getArguments()[0] ?? null) ?: null;

                break;
            }
        }

        $this->method = strtolower($this->method);
    }
}
