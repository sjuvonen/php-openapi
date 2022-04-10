<?php

namespace Juvonet\OpenApi\Processor;

class ProcessorChain
{
    public function __construct(
        private iterable $processors
    ) {
    }

    public function __invoke(OpenApi $openApi): void
    {
        foreach ($this->processors as $processor) {
            $processor($openApi);
        }
    }
}
