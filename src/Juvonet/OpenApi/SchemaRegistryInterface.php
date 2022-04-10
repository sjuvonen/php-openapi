<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\Schema;

interface SchemaRegistryInterface
{
    public function add(Ref|Schema $schema): void;
    public function getByClass(string $class, ?array $context = null): Schema;
    public function getByHash(string $hash): Schema;
    public function getByRef(Ref|string $ref): Schema;
    public function resolvePath(Ref|Schema $schema): string;
}
