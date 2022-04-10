<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Context;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\Documentation\Schema;

class AttributeSchemaDescriber extends PublicSchemaDescriber
{
    public function supports(Schema $schema): bool
    {
        return $schema->context->class !== null;
    }

    protected function extractFromProperties(string $className, Context $parentContext): iterable
    {
        $rclass = new \ReflectionClass($className);

        /**
         * Class properties can only be resolved directly from the class where
         * they have been declared...
         */
        do {
            foreach ($rclass->getProperties() as $rprop) {
                if ($attributes = $rprop->getAttributes(Property::class)) {
                    $context = $parentContext
                        ->with('file', $rclass->getFileName())
                        ->with('class', $rclass->getName())
                        ->with('property', $rprop->getName())
                        ;

                    $property = $attributes[0]->newInstance();
                    $property->property = $rprop->getName();
                    $property->setContext($context);

                    yield $property;
                }
            }
        } while ($rclass = $rclass->getParentClass());
    }

    protected function extractFromMethods(string $className, Context $parentContext): iterable
    {
        $rclass = new \ReflectionClass($className);

        foreach ($rclass->getMethods(\ReflectionProperty::IS_PUBLIC) as $rmethod) {
            if (!preg_match(static::METHOD_REGEX, $rmethod->getName())) {
                continue;
            }

            if ($attributes = $rmethod->getAttributes(Property::class)) {
                $context = $parentContext
                    ->with('file', $rclass->getFileName())
                    ->with('class', $rclass->getName())
                    ->with('method', $rmethod->getName())
                    ;

                $propertyName = preg_replace(static::METHOD_REGEX, '$2', $rmethod->getName());
                $propertyName = $this->normalizeName($propertyName);

                $property = $attributes[0]->newInstance();
                $property->setContext($context);
                $property->property = $propertyName;

                yield $property;
            }
        }
    }
}
