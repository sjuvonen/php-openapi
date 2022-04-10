<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\PathItem;
use Juvonet\OpenApi\Documentation\OpenApi;

final class SortPathsByTags
{
    public function __invoke(OpenApi $openApi): void
    {
        $pathItems = [...$openApi->paths];

        usort($pathItems, fn (PathItem $a, PathItem $b) => strcasecmp($a->tags[0] ?? '', $b->tags[0] ?? ''));

        foreach ($pathItems as $pathItem) {
            $openApi->paths->remove($pathItem->path);
            $openApi->paths->add($pathItem);
        }
    }
}
