<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaDescriberInterface;

class PropertySchemaDescriber implements SchemaDescriberInterface
{
    public function __construct(
        private \Juvonet\OpenApi\PropertyDescriberInterface $propertyDescriber
    ) {
    }

    public function supports(Schema $schema): bool
    {
        return count($schema->properties) > 0;
    }

    public function describe(Schema $schema): void
    {
        foreach ($schema->properties as $property) {
            if ($this->propertyDescriber->supports($property)) {
                $this->propertyDescriber->describe($property);
            }
        }
    }
}
