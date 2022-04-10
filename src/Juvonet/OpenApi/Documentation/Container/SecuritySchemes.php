<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\SecurityScheme;

final class SecuritySchemes extends AbstractContainer
{
    public function __construct(
        array $securitySchemes
    ) {
        parent::__construct($securitySchemes, SecurityScheme::class, 'securityScheme');
    }
}
