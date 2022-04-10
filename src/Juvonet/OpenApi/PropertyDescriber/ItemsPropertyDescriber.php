<?php

namespace Juvonet\OpenApi\PropertyDescriber;

use Juvonet\OpenApi\Documentation\Meta\Items;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\PropertyDescriberInterface;

class ItemsPropertyDescriber implements PropertyDescriberInterface
{
    public function supports(Property $property): bool
    {
        if ($property->context->class === null) {
            return false;
        }

        if (!in_array($property->type, [null, 'array'], true)) {
            return false;
        }

        return true;
    }

    public function describe(Property $property): void
    {
        try {
            $items = $this->extractItemsAttribute($property);

            $property->type = 'array';
            $property->items = $items;
        } catch (\UnderflowException) {
            // pass
        }
    }

    private function extractItemsAttribute(Property $property): Items
    {
        if ($property->context->property) {
            $rprop = new \ReflectionProperty($property->context->class, $property->context->property);

            foreach ($rprop->getAttributes(Items::class) as $items) {
                return $items->newInstance();
            }
        }

        if ($property->context->method) {
            $rprop = new \ReflectionMethod($property->context->class, $property->context->method);

            foreach ($rprop->getAttributes(Items::class) as $items) {
                return $items->newInstance();
            }
        }

        throw new \UnderflowException('No valid attribute available.');
    }
}
