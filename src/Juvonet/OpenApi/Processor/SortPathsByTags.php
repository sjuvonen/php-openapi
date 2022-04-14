<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\OpenApi;
use Juvonet\OpenApi\Documentation\PathItem;

final class SortPathsByTags
{
    public function __invoke(OpenApi $openApi): void
    {
        $pathItems = [...$openApi->paths];

        usort($pathItems, function (PathItem $a, PathItem $b) {
            $comparators = [
                \Closure::fromCallable([$this, 'compareTags']),
                \Closure::fromCallable([$this, 'comparePaths']),
            ];

            foreach ($comparators as $compare) {
                if ($d = $compare($a, $b)) {
                    return $d;
                }

                return 0;
            }
        });

        foreach ($pathItems as $pathItem) {
            $openApi->paths->remove($pathItem->path);
            $openApi->paths->add($pathItem);
        }
    }

    private function comparePaths(PathItem $a, PathItem $b): int
    {
        /**
         * Split paths by variables. ("/foo/bar/{id}/baz")
         */
        $a = preg_split('#/(?={)#', $a->path);
        $b = preg_split('#/(?={)#', $b->path);

        for ($i = 0; $i < max(count($a), count($b)); $i++) {
            $first = $a[$i] ?? '';
            $second = $b[$i] ?? '';

            if ($first !== $second) {
                return strcasecmp($first, $second);
            }
        }
    }

    private static function compareTags(PathItem $a, PathItem $b): int
    {
        $a = self::extractTags($a)[0] ?? null;
        $b = self::extractTags($b)[0] ?? null;

        if ($a && $b) {
            /**
             * Strips emojis in tag names.
             */
            $ac = preg_replace('/[[:^print:]]/', '', $a);
            $bc = preg_replace('/[[:^print:]]/', '', $b);

            /**
             * Test for path name starting with an emoji to sort them first.
             */
            $ae = substr_compare($a, $ac, 0, 1);
            $be = substr_compare($b, $bc, 0, 1);

            if ($ae !== $be) {
                return $be - $ae;
            } else {
                return strcasecmp($ac, $bc);
            }
        } else {
            return is_null($b) - is_null($a);
        }
    }

    private static function extractTags(PathItem $path): array
    {
        $operations = ['get', 'post', 'put', 'patch', 'delete'];

        foreach ($operations as $field) {
            $tags = $path->{$field}?->tags;

            if (!empty($tags)) {
                return $tags;
            }
        }

        return [];
    }
}
