<?php

namespace Juvonet\OpenApi\PropertyDescriber;

use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\PropertyDescriberInterface;
use WeakMap;

/**
 * Combines other property describers together.
 */
class PropertyDescriberChain implements PropertyDescriberInterface
{
    private WeakMap $visited;

    public function __construct(
        private iterable $describers
    ) {
        $this->visited = new WeakMap();
    }

    public function supports(Property $property): bool
    {
        foreach ($this->describers as $describer) {
            if ($describer->supports($property)) {
                return true;
            }
        }

        return false;
    }

    public function describe(Property $property): void
    {
        if ($this->visited->offsetExists($property)) {
            return;
        }

        $this->visited[$property] = true;

        foreach ($this->describers as $describer) {
            if ($describer->supports($property)) {
                $describer->describe($property);
            }
        }
    }
}
