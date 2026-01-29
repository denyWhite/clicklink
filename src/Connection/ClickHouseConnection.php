<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Connection;

use DenyWhite\ClickLink\Middleware\ClickHouseMiddlewareChain;
use DenyWhite\ClickLink\Protocol\ClickHouseQuery;
use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;
use DenyWhite\ClickLink\Transport\ClickHouseTransportInterface;

readonly class ClickHouseConnection implements ClickHouseConnectionInterface
{
    public function __construct(
        private ClickHouseConnectionConfig   $config,
        private ClickHouseTransportInterface $transport,
        private ?ClickHouseMiddlewareChain   $middlewareChain = null,
    )
    {
    }

    /** @inheritdoc */
    public function execute(ClickHouseQuery $query): ClickHouseResponse
    {
        $request = new ClickHouseRequest($query);

        return $this->dispatch($request);
    }

    /** @inheritdoc */
    public function dispatch(ClickHouseRequest $request): ClickHouseResponse
    {
        $request = $request->config ? $request : new ClickHouseRequest(
            $request->query,
            $this->config
        );

        if ($this->middlewareChain === null) {
            return $this->transport->send($request);
        }

        return $this->middlewareChain->handle($request, fn(ClickHouseRequest $request): ClickHouseResponse => $this->transport->send($request));
    }

    /** @inheritdoc */
    public function ping(): bool
    {
        try {
            $this->execute(new ClickHouseQuery('SELECT 1'));
        } catch (\Throwable) {
            return false;
        }
        return true;
    }

    /** @inheritdoc */
    public function getConfig(): ClickHouseConnectionConfig
    {
        return $this->config;
    }
}