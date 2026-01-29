<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Tests\Unit\Middleware\Fake;

use DenyWhite\ClickLink\Middleware\ClickHouseMiddlewareInterface;
use DenyWhite\ClickLink\Protocol\ClickHouseQuery;
use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;

class FakeMiddleware2 implements ClickHouseMiddlewareInterface
{
    public function __construct(
        public int $handleCounter = 0
    )
    {
    }

    public function handle(ClickHouseRequest $request, callable $next): ClickHouseResponse
    {
        $this->handleCounter++;

        $newRequest = new ClickHouseRequest(new ClickHouseQuery($request->query->getRawQuery() . '2'));
        $response = $next($newRequest);
        $newHeaders = $response->headers + [
                'fakeMiddleware2' => 'call',
            ];
        return new ClickHouseResponse($response->rawBody, $newHeaders, $response->format);
    }
}