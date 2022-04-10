<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\MediaType;

final class MediaTypes extends AbstractContainer
{
    public function __construct(
        MediaType|array $mediaTypes = []
    ) {
        parent::__construct($mediaTypes, MediaType::class, 'mediaType');
    }
}
