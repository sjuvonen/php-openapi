<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\Stdlib\Iterator\RecursiveObjectIterator;
use WeakMap;

class Dereference
{
    private array $counter;
    private array $discoveredSchemas;
    private WeakMap $consumed;

    public function __construct(
        private \Juvonet\OpenApi\DereferencerInterface $dereferencer,
        private \Juvonet\OpenApi\SchemaDescriberInterface $schemaDescriber,
        private \Juvonet\OpenApi\SchemaRegistryInterface $schemaRegistry,
    ) {
    }

    public function __invoke(OpenApi $api): void
    {
        $this->consumed = new WeakMap();
        $this->discoveredSchemas = [];

        $this->processObject($api, $api);

        while ($this->discoveredSchemas) {
            $schema = array_shift($this->discoveredSchemas);

            if ($this->schemaDescriber->supports($schema)) {
                $this->schemaDescriber->describe($schema);

                $this->processObject($api, $schema);
            }
        }
    }

    private function processObject(OpenApi $api, object $object): void
    {
        $this->counter = [];

        $iterator = new RecursiveObjectIterator($object);

        foreach ($iterator as $key => $object) {
            if (isset($object->ref) && $object->ref instanceof Ref) {
                $this->refCount($object);
            }
        }

        foreach ($this->counter as $parents) {
            $this->replaceRefs($api, $parents);
        }
    }

    private function refCount(object $parent): void
    {
        $hash = $parent->ref->hash();

        if (!isset($this->counter[$hash])) {
            $this->counter[$hash] = [$parent];
        } else {
            $this->counter[$hash][] = $parent;
        }
    }

    private function replaceRefs(OpenApi $api, array $parents): void
    {
        $schema = $this->dereferencer->dereference($parents[0]->ref);

        if (!$this->consumed->offsetExists($schema)) {
            $this->consumed[$schema] = true;
            $this->discoveredSchemas[] = $schema;

            $api->components->schemas->add($schema);
        }

        foreach ($parents as $parent) {
            $parent->ref = $this->schemaRegistry->resolvePath($schema);
        }
    }
}
