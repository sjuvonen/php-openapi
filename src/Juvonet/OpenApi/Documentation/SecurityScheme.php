<?php

namespace Juvonet\OpenApi\Documentation;

final class SecurityScheme
{
    public function __construct(
        public ?string $bearerFormat = null,
        public ?string $description = null,
        public ?string $in = null,
        public ?string $name = null,
        public ?string $openIdConnectUrl = null,
        public ?string $scheme = null,
        public ?string $securityScheme = null,
        public ?string $type = null,
    ) {
    }
}
