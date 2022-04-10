<?php

namespace Juvonet\OpenApi\OperationDescriber;

use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\OperationDescriberInterface;

final class OperationDescriberChain implements OperationDescriberInterface
{
    public function __construct(
        private iterable $describers
    ) {
    }

    public function supports(Operation $operation): bool
    {
        foreach ($this->describers as $describer) {
            if ($describer->supports($operation)) {
                return true;
            }
        }

        return false;
    }

    public function describe(Operation $operation): void
    {
        foreach ($this->describers as $describer) {
            if ($describer->supports($operation)) {
                $describer->describe($operation);
            }
        }
    }
}
