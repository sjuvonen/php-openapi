<?php

namespace Juvonet\OpenApi\Serializer\Exception;

final class IgnoreValueException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('This value should not be serialized.');
    }
}
