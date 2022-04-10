<?php

namespace Juvonet\OpenApi\Documentation\Container;

use Juvonet\OpenApi\Documentation\Operation;
use Juvonet\OpenApi\Documentation\Property;

final class Properties extends AbstractContainer
{
    public function __construct(
        array $properties = []
    ) {
        parent::__construct($properties, Property::class, 'property');
    }
}
