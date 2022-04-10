<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Documentation\Operation;

class DescribeOperations
{
    public function __construct(
        private \Juvonet\OpenApi\OperationDescriberInterface $operationDescriber
    ) {
    }

    public function __invoke(OpenApi $api): void
    {
        foreach ($api->paths as $path) {
            foreach ($path as $operation) {
                if (!($operation instanceof Operation)) {
                    continue;
                }

                if ($this->operationDescriber->supports($operation)) {
                    $this->operationDescriber->describe($operation);
                }
            }
        }
    }
}
