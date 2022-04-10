<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\OpenApi;

interface SerializerInterface
{
    public function serialize(array|object|null $openApi): string;
}
