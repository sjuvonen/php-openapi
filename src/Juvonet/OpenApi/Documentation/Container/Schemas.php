<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaRegistryInterface;

final class Schemas extends AbstractContainer
{
    public readonly SchemaRegistryInterface $registry;

    public function __construct(
        array $schemas
    ) {
        parent::__construct($schemas, Schema::class, 'schema');
    }

    public function add(object $schema): void
    {
        if (isset($this->registry)) {
            $this->registry->add($schema);

            if ($schema instanceof Ref) {
                $schema = $this->registry->getByRef($schema);
            }
        } elseif ($schema instanceof Ref) {
            throw new \UnexpectedValueException('Cannot add refs instead of schemas without a schema registry.');
        }

        parent::add($schema);
    }

    public function setRegistry(SchemaRegistryInterface $registry): void
    {
        $this->registry = $registry;
    }
}
