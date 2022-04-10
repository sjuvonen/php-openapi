<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\Header;

final class Headers extends AbstractContainer
{
    public function __construct(
        array $headers = []
    ) {
        parent::__construct($headers, Header::class, 'header');
    }
}
