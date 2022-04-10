<?php

namespace Juvonet\OpenApi\PropertyDescriber;

use Juvonet\OpenApi\Documentation\Property;
use Juvonet\OpenApi\PropertyDescriberInterface;

/**
 * Filters out blocks of comments that have been marked as internal using PHPDoc
 * syntax.
 */
class FilterInternalCommentPropertyDescriber implements PropertyDescriberInterface
{
    public function supports(Property $property): bool
    {
        return $property->title || $property->description;
    }

    public function describe(Property $property): void
    {
        if ($property->title) {
            $property->title = $this->filterInternalComment($property->title);
        }

        if ($property->description) {
            $property->description = $this->filterInternalComment($property->description);
        }
    }

    private function filterInternalComment(string $comment): ?string
    {
        $comment = preg_replace('/\s*\{@internal\s.+\}\}/s', '', $comment);
        $comment = trim($comment);

        return $comment ?: null;
    }
}
