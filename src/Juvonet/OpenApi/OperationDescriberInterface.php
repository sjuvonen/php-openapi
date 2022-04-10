<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\Operation;

interface OperationDescriberInterface
{
    public function supports(Operation $schema): bool;
    public function describe(Operation $schema): void;
}
