<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaDescriberInterface;

final class SortPropertiesSchemaDescriber implements SchemaDescriberInterface
{
    public function supports(Schema $schema): bool
    {
        return count($schema->properties) > 0;
    }

    public function describe(Schema $schema): void
    {
        $properties = [...$schema->properties];

        ksort($properties);

        foreach ($properties as $key => $property) {
            $schema->properties->remove($key);
            $schema->properties->add($property);
        }
    }
}
