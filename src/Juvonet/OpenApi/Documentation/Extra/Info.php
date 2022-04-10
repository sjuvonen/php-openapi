<?php

namespace Juvonet\OpenApi\Documentation\Extra;

final class Info
{
    public function __construct(
        public ?string $version = null,
        public ?string $title = null,
        public ?string $description = null,
    ) {
    }
}
