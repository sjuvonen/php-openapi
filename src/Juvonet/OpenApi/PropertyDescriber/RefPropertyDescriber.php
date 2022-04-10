<?php

namespace Juvonet\OpenApi\PropertyDescriber;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\PropertyDescriberInterface;

class RefPropertyDescriber implements PropertyDescriberInterface
{
    public function __construct(
        private \Juvonet\OpenApi\SchemaRegistryInterface $schemaRegistry,
    ) {
    }

    public function supports(Property $property): bool
    {
        return $property->ref instanceof Ref;
    }

    public function describe(Property $property): void
    {
        $path = $this->schemaRegistry->resolvePath($property->ref);
        $property->ref = $path;
    }
}
