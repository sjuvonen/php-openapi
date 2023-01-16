<?php

namespace Juvonet\OpenApi\Service;

use Juvonet\OpenApi\Context;
use Juvonet\OpenApi\Documentation\Extra\Ref;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\SchemaRegistryInterface;
use Juvonet\OpenApi\Utils;

final class SchemaRegistry implements SchemaRegistryInterface
{
    private array $byHash = [];
    private array $byPath = [];

    public function add(Ref|Schema $schema): void
    {
        if ($schema instanceof Ref) {
            $schema = $this->makeSchema($schema);
        }

        $hash = $schema->hash();

        if (!isset($this->byHash[$hash])) {
            $this->byHash[$hash] = $schema;

            $path = $this->resolvePath($schema);
            $this->byPath[$path] = $schema;
        } elseif ($this->byHash[$hash] !== $schema) {
            throw new \OverflowException("Schema for class {$schema->context->class} is already registered.");
        }
    }

    public function resolvePath(Ref|Schema $schema): string
    {
        if ($schema instanceof Ref) {
            $schema = $this->getByRef($schema);
        }

        if (!$schema->schema) {
            throw new \UnexpectedValueException("Cannot resolve path for schema without an identifier.");
        }

        return "#/components/schemas/{$schema->schema}";
    }

    public function getByClass(string $class, ?array $context = null): Schema
    {
        if ($context) {
            sort($context);
            $context = serialize($context);
        }

        try {
            return $this->getByHash(sha1($class . $context ?? ''));
        } catch (\OutOfBoundsException) {
            throw new \OutOfBoundsException("There is no schema registered for class {$class}.");
        }
    }

    public function getByHash(string $hash): Schema
    {
        if (!isset($this->byHash[$hash])) {
            throw new \OutOfBoundsException("There is no schema registered for hash {$hash}.");
        }

        return $this->byHash[$hash];
    }

    public function getByRef(Ref|string $ref): Schema
    {
        try {
            if (is_string($ref)) {
                return $this->byPath($ref);
            }

            return $this->getByHash($ref->hash());
        } catch (\OutOfBoundsException) {
            throw new \OutOfBoundsException("There is no schema registered for class {$ref->class}.");
        }
    }

    private function byPath(string $path): Schema
    {
        if (isset($this->byPath[$path])) {
            return $this->byPath[$path];
        } else {
            throw new \OutOfBoundsException("Could not resolve schema by path '{$path}'.");
        }
    }

    private function makeSchema(Ref $ref): Schema
    {
        $schema = new Schema(
            schema: Utils::identifierFromClassName($ref->class),
            x: $ref->options ?? []
        );

        $schema->setContext(new Context(
            file: (new \ReflectionClass($ref->class))->getFileName(),
            class: $ref->class
        ));

        for ($i = 0; isset($this->byPath[$this->resolvePath($schema)]); $i++) {
            if ($i) {
                $schema->schema = sprintf('%s-%d', substr($schema->schema, 0, strlen($i)), $i + 1);
            } else {
                $schema->schema = "{$schema->schema}-1";
            }
        }

        return $schema;
    }
}
