<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\DataAccess;

use DenyWhite\ClickLink\Connection\ClickHouseConnectionInterface;
use DenyWhite\ClickLink\Protocol\ClickHouseQuery;
use DenyWhite\ClickLink\Result\ClickHouseResult;
use DenyWhite\ClickLink\Result\Parser\ClickHouseResultParser;

class ClickHouseDataReader
{
    public function __construct(
        private ClickHouseConnectionInterface $connection,
        private ClickHouseResultParser $parser,
    )
    {
    }

    public function fetch(string $sql, array $bindings = []): ClickHouseResult
    {
        return $this->parser->parse($this->connection->execute(new ClickHouseQuery($sql, $bindings)));
    }
}