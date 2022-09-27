<?php

namespace Juvonet\OpenApi;

use Juvonet\OpenApi\Documentation\AbstractSchema;
use Juvonet\OpenApi\Documentation\Extra\Ref;

interface DereferencerInterface
{
    public function dereference(Ref $ref): AbstractSchema;
}
