<?php

namespace Juvonet\OpenApi\Documentation\Extra;

use Juvonet\OpenApi\Documentation\MediaType;
use Juvonet\OpenApi\Documentation\Schema;

final class CsvContent extends MediaType
{
    public function __construct(
        array|null $encoding = null,
        bool $multipart = false,
        mixed $example = null,
        string $separator = ',',
        Schema|null $schema = null,
        Ref|string|null $ref = null
    ) {
        if (!$ref && !$schema) {
            $schema = new Schema(
               type: 'string',
               format: 'csv',
           );
        }

        parent::__construct(
            encoding: $encoding,
            example: $example ?? "foo{$separator}bar{$separator}baz\naaa{$separator}bbb{$separator}ccc",
            mediaType: 'text/csv',
            ref: $ref,
            schema: $schema,
        );
    }
}
