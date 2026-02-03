<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\DataAccess;

use DenyWhite\ClickLink\Connection\ClickHouseConnectionInterface;
use DenyWhite\ClickLink\Protocol\ClickHouseQuery;

class ClickHouseDataWriter
{
    public function __construct(
        private ClickHouseConnectionInterface $connection,
    )
    {
    }

    public function execute(string $sql, array $bindings = []): void
    {
        $this->connection->execute(new ClickHouseQuery($sql, $bindings));
    }
}