<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Extra\Ref;

class MediaType
{
    public string $mediaType;

    public function __construct(
        public array|null $encoding = null,
        public mixed $example = null,
        public Schema|null $schema = null,
        string|null $mediaType = null,
        Ref|string|null $ref = null
    ) {
        $this->mediaType = $this->mediaType ?? $mediaType;

        if ($ref) {
            $this->schema = new Schema(ref: $ref);
        }

        if (!$this->schema) {
            throw new \LogicException('Must pass either $schema or $ref to a MediaType.');
        }
    }
}
