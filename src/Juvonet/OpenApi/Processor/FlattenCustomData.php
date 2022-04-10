<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\Stdlib\Iterator\RecursiveObjectIterator;

class FlattenCustomData
{
    public function __invoke(OpenApi $api): void
    {
        $iterator = new RecursiveObjectIterator($api);

        foreach ($iterator as $key => $object) {
            if (($object->ref ?? null) instanceof Ref) {
                $this->refCount($object);
            }
        }
    }
}
