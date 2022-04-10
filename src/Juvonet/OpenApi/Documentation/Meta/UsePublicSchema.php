<?php

namespace Juvonet\OpenApi\Documentation\Meta;

/**
 * Allows importing public schema from classes into the OpenApi Schema object.
 */
#[
    \Attribute(\Attribute::TARGET_CLASS)
]
final class UsePublicSchema
{
}
