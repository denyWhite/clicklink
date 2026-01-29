<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Middleware;

use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;

class ClickHouseMiddlewareChain
{
    /**
     * @var ClickHouseMiddlewareInterface[]
     */
    private array $middlewares;

    public function __construct(ClickHouseMiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function add(ClickHouseMiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @param callable(ClickHouseRequest): ClickHouseResponse $final
     */
    public function handle(ClickHouseRequest $request, callable $final): ClickHouseResponse
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            static fn(callable $next, ClickHouseMiddlewareInterface $middleware) => static fn(ClickHouseRequest $r) => $middleware->handle($r, $next),
            $final
        );

        return $pipeline($request);
    }
}