<?php

namespace Juvonet\OpenApi\PropertyDescriber;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\PropertyDescriberInterface;
use Juvonet\OpenApi\Util\Reflection;

/**
 * Maps DateInterval objects to date-interval type.
 *
 * Property types are resolved using reflection.
 *
 * This type describer will NOT overwrite previously set property types.
 */
class DateIntervalPropertyDescriber implements PropertyDescriberInterface
{
    public function supports(Property $property): bool
    {
        return $property->context->class !== null && $property->type == null;
    }

    public function describe(Property $property): void
    {
        if ($this->isDateIntervalProperty($property)) {
            $property->type = 'string';
            $property->format = 'date-interval';
            $property->example = 'P0Y0M0DT0H0M0S';
        }
    }

    private function isDateIntervalProperty(Property $property): bool
    {
        if ($property->context->property) {
            $rprop = new \ReflectionProperty($property->context->class, $property->context->property);

            return Reflection::hasType($rprop->getType(), \DateInterval::class);
        }

        if ($property->context->method) {
            $rmethod = new \ReflectionMethod($property->context->class, $property->context->method);

            return Reflection::hasType($rmethod->getReturnType(), \DateInterval::class);
        }

        return false;
    }
}
