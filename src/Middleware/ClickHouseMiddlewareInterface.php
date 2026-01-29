<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Middleware;

use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;

interface ClickHouseMiddlewareInterface
{
    /**
     * @param callable(ClickHouseRequest): ClickHouseResponse $next
     */
    public function handle(ClickHouseRequest $request, callable $next): ClickHouseResponse;
}