<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\Property;

interface PropertyDescriberInterface
{
    public function supports(Property $property): bool;
    public function describe(Property $property): void;
}
