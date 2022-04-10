<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\Response;

final class Responses extends AbstractContainer
{
    public function __construct(
        Response|array $responses
    ) {
        parent::__construct($responses, Response::class, 'response');
    }
}
