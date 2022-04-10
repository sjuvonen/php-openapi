<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\OpenApi;

interface LoaderInterface
{
    public function load(OpenApi $api): void;
}
