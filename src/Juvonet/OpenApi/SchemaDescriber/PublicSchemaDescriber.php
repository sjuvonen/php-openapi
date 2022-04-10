<?php

namespace Juvonet\OpenApi\SchemaDescriber;

use Juvonet\OpenApi\Context;
use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaDescriberInterface;

class PublicSchemaDescriber implements SchemaDescriberInterface
{
    public const METHOD_REGEX = '/^(get|has|is)([A-Z])/';

    public function __construct(
        private array $namespaces = [],
        private bool $fallback = false,
    ) {
    }

    public function supports(Schema $schema): bool
    {
        if ($this->fallback && !count($schema->properties)) {
            return true;
        }

        try {
            $rclass = new \ReflectionClass($schema->context->class);
            $attributes = $rclass->getAttributes(\Juvonet\OpenApi\Documentation\Meta\UsePublicSchema::class);

            if (!empty($attributes)) {
                return true;
            }

            foreach ($this->namespaces as $namespace) {
                $namespace = rtrim($namespace, '\\') . '\\';

                if (strpos($schema->context->class, $namespace) === 0) {
                    return true;
                }
            }

            return false;
        } catch (\ReflectionException) {
            return false;
        }
    }

    public function describe(Schema $schema): void
    {
        $properties = [
            ...$this->extractFromProperties($schema->context->class, $schema->context),
            ...$this->extractFromMethods($schema->context->class, $schema->context),
        ];

        foreach ($properties as $property) {
            $schema->properties->add($property);
        }
    }

    protected function extractFromProperties(string $className, Context $parentContext): iterable
    {
        $rclass = new \ReflectionClass($className);

        /**
         * Class properties can only be resolved directly from the class where
         * they have been declared...
         */
        do {
            foreach ($rclass->getProperties(\ReflectionProperty::IS_PUBLIC) as $rprop) {
                $context = $parentContext
                    ->with('file', $rclass->getFileName())
                    ->with('class', $rclass->getName())
                    ->with('property', $rprop->getName())
                    ;

                $property = new Property($rprop->getName());
                $property->setContext($context);

                yield $property;
            }
        } while ($rclass = $rclass->getParentClass());
    }

    protected function extractFromMethods(string $className, Context $parentContext): iterable
    {
        $rclass = new \ReflectionClass($className);

        foreach ($rclass->getMethods(\ReflectionProperty::IS_PUBLIC) as $rmethod) {
            if (!preg_match(self::METHOD_REGEX, $rmethod->getName())) {
                continue;
            }

            $context = $parentContext
                ->with('file', $rclass->getFileName())
                ->with('class', $rclass->getName())
                ->with('method', $rmethod->getName())
                ;

            $propertyName = preg_replace(self::METHOD_REGEX, '$2', $rmethod->getName());
            $propertyName = $this->normalizeName($propertyName);

            $property = new Property($propertyName);
            $property->setContext($context);

            yield $property;
        }
    }

    protected function normalizeName(string $propertyName): string
    {
        return lcfirst($propertyName);
    }
}
