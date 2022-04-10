<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Context;

/**
 * Base class for classes that serve as PHP attributes and can be discovered by
 * file loaders.
 */
abstract class DiscoverableAttribute
{
    public readonly ?Context $context;

    public function setContext(?Context $context): void
    {
        $this->context = $context;
    }
}
