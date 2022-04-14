<?php

namespace Juvonet\OpenApi\PropertyDescriber;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\PropertyDescriberInterface;

/**
 * "Describes" all object properties by assigning a ref to the target class.
 */
class ObjectPropertyDescriber implements PropertyDescriberInterface
{
    public function supports(Property $property): bool
    {
        if ($property->type) {
            return false;
        }

        if ($property->ref) {
            return false;
        }

        try {
            $this->resolveTargetClass($property);

            return true;
        } catch (\UnexpectedValueException) {
            return false;
        }
    }

    public function describe(Property $property): void
    {
        $className = $this->resolveTargetClass($property);

        $property->ref = new Ref($className);
    }

    private function resolveTargetClass(Property $property): string
    {
        if ($property->context->property) {
            $rprop = new \ReflectionProperty($property->context->class, $property->context->property);
            $className = $rprop->getType()?->getName() ?? '';

            if (class_exists($className) || interface_exists($className)) {
                return $className;
            }
        }

        if ($property->context->method) {
            $rmethod = new \ReflectionMethod($property->context->class, $property->context->method);
            $className = $rmethod->getReturnType()?->getName() ?? '';

            if (class_exists($className) || interface_exists($className)) {
                return $className;
            }
        }

        throw new \UnexpectedValueException('Not a valid object property');
    }
}
