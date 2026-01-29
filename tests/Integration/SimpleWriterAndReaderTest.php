<?php
declare(strict_types=1);

use DenyWhite\ClickLink\Connection\ClickHouseConnection;
use DenyWhite\ClickLink\Connection\ClickHouseConnectionConfig;
use DenyWhite\ClickLink\DataAccess\ClickHouseDataReader;
use DenyWhite\ClickLink\DataAccess\ClickHouseDataWriter;
use DenyWhite\ClickLink\Result\Parser\ClickHouseResultParser;
use DenyWhite\ClickLink\Transport\Guzzle\GuzzleTransport;
use PHPUnit\Framework\TestCase;

class SimpleWriterAndReaderTest extends TestCase
{
    public function testWriteAndRead(): void
    {
        $connection = new ClickHouseConnection(
            new ClickHouseConnectionConfig(),
            new GuzzleTransport(),
        );

        $dataReader = new ClickHouseDataReader($connection, new ClickHouseResultParser());
        $dataWriter = new ClickHouseDataWriter($connection);

        $dataWriter->execute('DROP TABLE IF EXISTS test');
        $dataWriter->execute('CREATE TABLE IF NOT EXISTS test (value UInt16) ENGINE = Memory');

        $dataWriter->execute('INSERT INTO test (value) SELECT number FROM numbers(1, 5)');

        $result = $dataReader->fetch('SELECT count(*) FROM test');
        self::assertCount(1, $result);
        self::assertEquals([
            ['count()' => '5']
        ], $result->rows());

        $result = $dataReader->fetch('SELECT value FROM test');
        self::assertCount(5, $result);
        self::assertEquals([
            ['value' => 1],
            ['value' => 2],
            ['value' => 3],
            ['value' => 4],
            ['value' => 5],
        ], $result->rows());

        $dataWriter->execute('DROP TABLE IF EXISTS test');
    }
}