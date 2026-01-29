<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Tests\Unit\Result\ClickHouseResultTest\Fake;

class TestDto
{
    public function __construct(
        public int    $id,
        public string $value,
    )
    {
    }
}