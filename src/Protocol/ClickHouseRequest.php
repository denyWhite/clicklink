<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Protocol;

use DenyWhite\ClickLink\Connection\ClickHouseConnectionConfig;

readonly class ClickHouseRequest
{
    public function __construct(
        public ClickHouseQuery             $query,
        public ?ClickHouseConnectionConfig $config = null,
    )
    {
    }
}