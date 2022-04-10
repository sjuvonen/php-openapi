<?php

namespace Juvonet\OpenApi\Loader;

use Juvonet\OpenApi\LoaderInterface;
use Juvonet\OpenApi\Documentation\OpenApi;

/**
 * Chains other loaders together.
 */
class LoaderChain implements LoaderInterface
{
    public function __construct(
        private iterable $loaders = []
    ) {
    }

    public function load(OpenApi $api): void
    {
        foreach ($this->loaders as $loader) {
            if (!($loader instanceof LoaderInterface)) {
                $loaderClass = get_class($loader);

                throw new \InvalidArgumentException("Registered loader {$loaderClass} must implement LoaderInterface.");
            }

            $loader->load($api);
        }
    }
}
