<?php

namespace Juvonet\OpenApi\Processor;

use Juvonet\OpenApi\Documentation\OpenApi;

class DescribeProject
{
    public function __construct(
        private ?string $version = null,
        private ?string $title = null,
        private ?string $description = null,
    ) {
    }

    public function __invoke(OpenApi $api): void
    {
        $api->info->version = $this->version;
        $api->info->title = $this->title;
        $api->info->description = $this->description;
    }
}
