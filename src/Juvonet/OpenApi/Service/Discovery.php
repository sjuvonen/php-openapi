<?php

namespace Juvonet\OpenApi\Service;

use Juvonet\OpenApi\DiscoveryInterface;

final class Discovery implements DiscoveryInterface
{
    public function scan(array $paths): iterable
    {
        foreach ($paths as $path) {
            $iterator = new \RecursiveDirectoryIterator($path, \FilesystemIterator::CURRENT_AS_PATHNAME);
            $iterator = new \RecursiveIteratorIterator($iterator);

            foreach ($iterator as $filePath) {
                if (is_file($filePath)) {
                    yield $filePath;
                }
            }
        }
    }
}
