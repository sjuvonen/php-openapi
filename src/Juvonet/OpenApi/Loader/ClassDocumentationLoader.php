<?php

namespace Juvonet\OpenApi\Loader;

use Juvonet\OpenApi\Context;
use Juvonet\OpenApi\LoaderInterface;
use Juvonet\OpenApi\Documentation\DiscoverableAttribute;
use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\Documentation\Schema;
use Juvonet\OpenApi\Utils;

/**
 * Discovers documentation from attributes in PHP classes.
 */
class ClassDocumentationLoader implements LoaderInterface
{
    public function __construct(
        private \Juvonet\OpenApi\DiscoveryInterface $discovery,
        private array $paths = [],
    ) {
    }

    public function load(OpenApi $api): void
    {
        $filePaths = $this->discovery->scan($this->paths);

        foreach ($filePaths as $filePath) {
            if ($this->supports($filePath)) {
                $this->loadFile($filePath, $api);
            }
        }
    }

    private function supports(string $filePath): bool
    {
        return substr($filePath, -4) === '.php';
    }

    private function loadFile(string $filePath, OpenApi $api): void
    {
        // print "LOAD {$filePath}\n";

        foreach ($this->extractDeclaredClasses($filePath) as $className) {
            // print "ANALYZE {$className}\n";

            foreach ($this->extractAttributesFromClass($className) as $attribute) {
                $aname = $attribute->getName();
                // print "LOAD {$filePath}\n";
                // print "\tATTRIBUTE {$aname}\n";

                $this->addAttribute($api, $attribute, new Context(
                    file: $filePath,
                    class: $className,
                ));
            }

            foreach ($this->extractAttributesFromClassMethods($className) as [$methodName, $attribute]) {
                $this->addAttribute($api, $attribute, new Context(
                    file: $filePath,
                    class: $className,
                    method: $methodName,
                ));
            }

            foreach ($this->extractAttributesFromClassProperties($className) as [$propertyName, $attribute]) {
                $this->addAttribute($api, $attribute, new Context(
                    file: $filePath,
                    class: $className,
                    property: $propertyName
                ));
            }
        }
    }

    private function addAttribute(OpenApi $api, object $attribute, Context $context): void
    {
        /**
         * NOTE: Do not (try to) instantiate the attribute until we know that it
         * is "safe" as not all attributes actually map to an existing class.
         *
         * Avoiding pointless instantiation will also be better for performance.
         */
        switch (true) {
            case is_a($attribute->getName(), Operation::class, true):
                $context = $context->with('method', $context->method ?? '__invoke');

                $operation = $attribute->newInstance();
                $operation->operationId = $operation->operationId ?? Utils::identifierFromClassName($context->class, $context->method);
                $operation->setContext($context);

                $api->paths->addOperation($operation);
                break;

            case is_a($attribute->getName(), Schema::class, true):
                $schema = $attribute->newInstance();
                $schema->schema = $schema->schema ?? Utils::identifierFromClassName($context->class);
                $schema->setContext($context);

                $api->components->schemas->add($schema);
                break;
        }
    }

    private function extractDeclaredClasses(string $filePath): iterable
    {
        $tokens = token_get_all(file_get_contents($filePath), TOKEN_PARSE);
        $namespace = null;
        $mode = 0;

        foreach ($tokens as $tokenData) {
            if (is_array($tokenData)) {
                [$token, $content] = $tokenData;
            } else {
                $token = null;
                $content = $tokenData;
            }

            switch ($token) {
                case T_NAMESPACE:
                    $mode = 1;
                    break;

                case T_CLASS:
                    $mode = 2;
                    break;

                /**
                 * Class name declaration is always T_STRING.
                 *
                 * Namespace declaration can be either T_STRING, for first-level
                 * namespaces, or T_NAME_QUALIFIED, for any namespace containing
                 * a backslash.
                 */
                case T_NAME_QUALIFIED:
                case T_STRING:
                    if ($mode === 1) {
                        $mode = 0;
                        $namespace = $content;
                    }

                    if ($mode === 2) {
                        $mode = 0;

                        if ($namespace) {
                            yield "{$namespace}\\{$content}";
                        } else {
                            yield $content;
                        }

                    }
                    break;
            }
        }
    }

    private function extractAttributesFromClass(string $className): iterable
    {
        try {
            $rclass = new \ReflectionClass($className);

            yield from $rclass->getAttributes();
        } catch (\ReflectionException) {
            /**
             * Our ad-hoc parser probably caught something that isn't a valid
             * class name.
             */
            yield from [];
        }
    }

    private function extractAttributesFromClassMethods(string $className): iterable
    {
        try {
            $rclass = new \ReflectionClass($className);

            foreach ($rclass->getMethods() as $rmethod) {
                foreach ($rmethod->getAttributes() as $attribute) {
                    yield [$rmethod->getName(), $attribute];
                }
            }
        } catch (\ReflectionException) {
            yield from [];
        }
    }

    private function extractAttributesFromClassProperties(string $className): iterable
    {
        try {
            $rclass = new \ReflectionClass($className);

            foreach ($rclass->getProperties() as $rprop) {
                foreach ($rprop->getAttributes() as $attribute) {
                    yield [$rprop->getName(), $attribute];
                }
            }
        } catch (\ReflectionException) {
            yield from [];
        }
    }
}
