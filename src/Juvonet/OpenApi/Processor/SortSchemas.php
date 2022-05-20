<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Documentation\Schema;

final class SortSchemas
{
    public function __invoke(OpenApi $openApi): void
    {
        $schemas = [...$openApi->components->schemas];

        usort($schemas, static function (Schema $a, Schema $b) {
            return strcasecmp($a->title ?? '', $b->title ?? '');
        });

        foreach ($schemas as $schema) {
            $openApi->components->schemas->remove($schema->schema);
            $openApi->components->schemas->add($schema);
        }
    }
}
