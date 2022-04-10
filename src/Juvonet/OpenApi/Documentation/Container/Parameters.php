<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\Documentation\Parameter;

final class Parameters extends AbstractContainer
{
    public function __construct(
        array $parameters = []
    ) {
        parent::__construct($parameters, Parameter::class);
    }
}
