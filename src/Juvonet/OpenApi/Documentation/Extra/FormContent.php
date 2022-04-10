<?php

namespace Juvonet\OpenApi\Documentation\Extra;

use Juvonet\OpenApi\Documentation\MediaType;
use Juvonet\OpenApi\Documentation\Schema;

final class FormContent extends MediaType
{
    public function __construct(
        array|null $encoding = null,
        bool $multipart = false,
        mixed $example = null,
        Schema|null $schema = null,
        Ref|string|null $ref = null
    ) {
        parent::__construct(
            mediaType: $multipart ? 'multipart/form-data' : 'application/x-www-form-urlencoded',
            encoding: $encoding,
            example: $example,
            schema: $schema,
            ref: $ref,
        );
    }
}
