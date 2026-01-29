<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Tests\Unit\Result\ClickHouseResultTest;

use DenyWhite\ClickLink\Result\ClickHouseResult;
use DenyWhite\ClickLink\Tests\Unit\Result\ClickHouseResultTest\Fake\TestDto;
use PHPUnit\Framework\TestCase;

class ClickHouseResultTest extends TestCase
{
    private ClickHouseResult $clickHouseResult;

    public function setUp(): void
    {
        $this->clickHouseResult = new ClickHouseResult([
            [
                'id' => 1,
                'value' => 'value1',
            ],
            [
                'id' => 2,
                'value' => 'value2',
            ],
            [
                'id' => 3,
                'value' => 'value3',
            ],
        ]);
    }

    public function testCount(): void
    {
        self::assertSame(3, $this->clickHouseResult->count());
        self::assertCount(3, $this->clickHouseResult);
    }

    public function testGetIterator(): void
    {
        $result = [];
        foreach ($this->clickHouseResult as $row) {
            $result[] = $row['id'];
        }
        self::assertEquals([1, 2, 3], $result);
    }

    public function testIterateAs(): void
    {
        $result = [];
        foreach ($this->clickHouseResult->iterateAs(TestDto::class) as $row) {
            self::assertInstanceOf(TestDto::class, $row);
            $result[] = $row->id;
        }
        self::assertEquals([1, 2, 3], $result);
    }

    public function testMapTo(): void
    {
        $mappedDto = $this->clickHouseResult->mapTo(TestDto::class);

        self::assertCount(3, $mappedDto);
        self::assertContainsOnlyInstancesOf(TestDto::class, $mappedDto);
    }
}