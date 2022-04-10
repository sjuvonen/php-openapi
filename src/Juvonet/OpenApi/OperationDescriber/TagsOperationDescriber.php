<?php

namespace Juvonet\OpenApi\OperationDescriber;

use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\OperationDescriberInterface;

class TagsOperationDescriber implements OperationDescriberInterface
{
    public function __construct(
        private array $trimPrefixes = []
    ) {
    }

    public function supports(Operation $operation): bool
    {
        return false;
        return !count($operation->tags);
    }

    public function describe(Operation $operation): void
    {
        $operation->tags[] = $this->extractTagFromPath($operation->path);
    }

    private function extractTagFromPath(string $path): string
    {
        $pathToTag = static function (string $path): string {
            $tag = explode('/', $path)[1] ?? 'default';
            $tag = strtr($tag, ['-' => ' ']);

            return $tag;
        };

        foreach ($this->trimPrefixes as $prefix) {
            if (strpos($path, $prefix . '/') === 0) {
                $path = substr($path, strlen($prefix));

                return $pathToTag($path);
            }
        }

        return $pathToTag($path);
    }
}
