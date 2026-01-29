<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Tests\Unit\Middleware;

use DenyWhite\ClickLink\Middleware\ClickHouseMiddlewareChain;
use DenyWhite\ClickLink\Protocol\ClickHouseQuery;
use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;
use DenyWhite\ClickLink\Tests\Unit\Middleware\Fake\FakeMiddleware1;
use DenyWhite\ClickLink\Tests\Unit\Middleware\Fake\FakeMiddleware2;
use PHPUnit\Framework\TestCase;

class ClickHouseMiddlewareChainTest extends TestCase
{
    public function testProcess(): void
    {
        $middleware1 = new FakeMiddleware1();
        $middleware2 = new FakeMiddleware2();
        $chain = new ClickHouseMiddlewareChain($middleware1, $middleware2);

        $request = new ClickHouseRequest(new ClickHouseQuery(''));

        $result = $chain->handle($request, static function (ClickHouseRequest $request) {
            self::assertSame($request->query->getRawQuery(), '12');
            return new ClickHouseResponse('', [], $request->query->getFormat());
        });

        self::assertEquals([
            'fakeMiddleware2' => 'call',
            'fakeMiddleware1' => 'call',
        ], $result->headers);

        self::assertSame(1, $middleware1->handleCounter);
        self::assertSame(1, $middleware2->handleCounter);
    }
}