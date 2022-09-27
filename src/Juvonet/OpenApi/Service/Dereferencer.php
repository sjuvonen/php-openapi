<?php

namespace Juvonet\OpenApi\Service;

use Juvonet\OpenApi\DereferencerInterface;
use Juvonet\OpenApi\Documentation\AbstractSchema;
use Juvonet\OpenApi\Documentation\Extra\Ref;

final class Dereferencer implements DereferencerInterface
{
    public function __construct(
        private \Juvonet\OpenApi\SchemaRegistryInterface $schemaRegistry
    ) {
    }

    public function dereference(Ref $ref): AbstractSchema
    {
        try {
            $this->schemaRegistry->add($ref);
        } catch (\OverflowException) {
            // Will throw when schema is already registered; pass.
        }

        $schema = $this->schemaRegistry->getByRef($ref);

        return $schema;
    }
}
