<?php

namespace Juvonet\OpenApi\Documentation\Operations;

use Juvonet\OpenApi\Documentation\Operation;

#[
    \Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD),
    \Juvonet\OpenApi\Documentation\Meta\HttpMethod('TRACE'),
]
final class Trace extends Operation
{
}
