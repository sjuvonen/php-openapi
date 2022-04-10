<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaDescriberInterface;

class InitializeSchemaDescriber implements SchemaDescriberInterface
{
    public function supports(Schema $schema): bool
    {
        return !$schema->ref && !$schema->type;
    }

    public function describe(Schema $schema): void
    {
        $schema->type = 'object';
    }
}
