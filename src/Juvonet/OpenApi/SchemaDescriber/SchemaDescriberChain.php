<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaDescriberInterface;
use WeakMap;

/**
 * Combines other schema describers together.
 */
class SchemaDescriberChain implements SchemaDescriberInterface
{
    private WeakMap $visited;

    public function __construct(
        private iterable $describers
    ) {
        $this->visited = new WeakMap();
    }

    public function supports(Schema $schema): bool
    {
        foreach ($this->describers as $describer) {
            if ($describer->supports($schema)) {
                return true;
            }
        }

        return false;
    }

    public function describe(Schema $schema): void
    {
        if ($this->visited->offsetExists($schema)) {
            return;
        }

        $this->visited[$schema] = true;

        foreach ($this->describers as $describer) {
            if ($describer->supports($schema)) {
                $describer->describe($schema);
            }
        }
    }
}
