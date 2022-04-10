<?php

namespace Juvonet\OpenApi;

interface DiscoveryInterface
{
    public function scan(array $paths): iterable;
}
