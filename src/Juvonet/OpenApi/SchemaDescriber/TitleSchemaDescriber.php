<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaDescriberInterface;

class TitleSchemaDescriber implements SchemaDescriberInterface
{
    public function supports(Schema $schema): bool
    {
        return $schema->title === null && $schema->context->class !== null;
    }

    public function describe(Schema $schema): void
    {
        $title = substr(strrchr($schema->context->class, '\\'), 1) ?: $schema->context->class;

        $schema->title = $title;
    }
}
