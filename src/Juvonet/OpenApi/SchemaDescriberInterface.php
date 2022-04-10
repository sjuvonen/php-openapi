<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\Schema;

interface SchemaDescriberInterface
{
    public function supports(Schema $schema): bool;
    public function describe(Schema $schema): void;
}
