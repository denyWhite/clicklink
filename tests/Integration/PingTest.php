<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Test\Integration;

use DenyWhite\ClickLink\Connection\ClickHouseConnection;
use DenyWhite\ClickLink\Connection\ClickHouseConnectionConfig;
use DenyWhite\ClickLink\Transport\Guzzle\GuzzleTransport;
use PHPUnit\Framework\TestCase;

class PingTest extends TestCase
{
    public function testPositive(): void
    {
        $connection = new ClickHouseConnection(new ClickHouseConnectionConfig(), new GuzzleTransport());
        self::assertTrue($connection->ping());
    }

    public function testNegative(): void
    {
        $connection = new ClickHouseConnection(new ClickHouseConnectionConfig(host: 'wrong', timeout: 0.1), new GuzzleTransport());
        self::assertFalse($connection->ping());
    }
}