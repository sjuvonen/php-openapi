<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\OpenApi;

interface DocumentationGeneratorInterface
{
    public function generate(): OpenApi;
}
