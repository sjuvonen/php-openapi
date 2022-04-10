<?php

namespace Juvonet\OpenApi\OperationDescriber;

use Juvonet\OpenApi\Context;
use Juvonet\OpenApi\Documentation\Enum\ExplodeStyle;
use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\AbstractSchema;
use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\Documentation\Parameter;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\OperationDescriberInterface;

class ParametersFromOperationDescriber implements OperationDescriberInterface
{
    private ExplodeStyle $explodeStyle;

    public function __construct(
        private \Juvonet\OpenApi\SchemaDescriberInterface $schemaDescriber,
        private \Juvonet\OpenApi\SchemaRegistryInterface $schemaRegistry,
        ExplodeStyle|string $explodeStyle = ExplodeStyle::SPACE_DELIMITED,
    ) {
        $this->explodeStyle = is_string($explodeStyle) ? ExplodeStyle::from($explodeStyle) : $explodeStyle;
    }

    public function supports(Operation $operation): bool
    {
        foreach ($operation->parameters as $parameter) {
            if ($parameter->from) {
                return true;
            }
        }

        return false;
    }

    public function describe(Operation $operation): void
    {
        foreach ($operation->parameters as $key => $template) {
            if (!$template->from) {
                continue;
            }

            $operation->parameters->remove($key);

            foreach ($this->extractProperties($template) as $parameter) {
                $operation->parameters->add($parameter);
            }
        }
    }

    private function extractProperties(Parameter $template): iterable
    {
        $from = $template->from;

        /**
         * We are not able to use `clone $schema` as readonly object properties
         * cannot be cloned as of now. Hence we have to produce a clone of the
         * main schema manually.
         */
        if ($from instanceof Ref) {
            $schema = new Schema();
            $schema->setContext(new Context(
                file: (new \ReflectionClass($from->class))->getFileName(),
                class: $from->class,
            ));

            $this->schemaDescriber->describe($schema);
        } else {
            $source = $this->schemaRegistry->getByPath($from);
            $schema = new Schema();
            $schema->setContext(new Context(
                file: $source->context->file,
                class: $source->context->class,
            ));

            $this->schemaDescriber->describe($schema);
        }

        foreach ($schema->properties as $property) {
            $parameter = new Parameter(
                name: $property->property,
                in: $template->in,
                explode: $template->explode,
                style: $template->style,

                /**
                 * Clone doesn't work as readonly object properties cannot be
                 * cloned implicitly..
                 */
                // schema: clone $property,
                schema: $property,
            );

           $this->processParameter($parameter);

            yield $parameter;
        }
    }

    private function processParameter(Parameter $parameter): void
    {
        $schema = $parameter->schema;

        if ($schema->type === 'array') {
            $schema->type = $schema->items?->type;
            $schema->items = null;

            $parameter->explode = true;
            $parameter->style = $parameter->style ?? $this->explodeStyle;
        }
    }
}
