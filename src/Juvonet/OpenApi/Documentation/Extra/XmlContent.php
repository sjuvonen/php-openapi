<?php

namespace Juvonet\OpenApi\Documentation\Extra;

use Juvonet\OpenApi\Documentation\MediaType;
use Juvonet\OpenApi\Documentation\Schema;

final class XmlContent extends MediaType
{
    public function __construct(
        array|null $encoding = null,
        bool $multipart = false,
        mixed $example = null,
        Schema|null $schema = null,
        Ref|string|null $ref = null
    ) {
        if (!$ref && !$schema) {
            $schema = new Schema(
               type: 'string',
               format: 'xml',
           );
        }

        parent::__construct(
            encoding: $encoding,
            example: $example,
            mediaType: 'application/xml',
            ref: $ref,
            schema: $schema,
        );
    }
}
