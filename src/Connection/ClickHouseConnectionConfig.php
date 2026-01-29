<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Connection;

readonly class ClickHouseConnectionConfig implements \Stringable
{
    public function __construct(
        public string $host = 'clickhouse',
        public int    $port = 8123,
        public string $username = 'external_user',
        public string $password = 'pass',
        public string $database = 'default',
        public bool   $isSecure = false,
        public float  $timeout = 2.0,
        public bool   $useCompression = true,
    )
    {
    }

    public function __toString(): string
    {
        return sprintf('%s:%d', $this->host, $this->port);
    }
}