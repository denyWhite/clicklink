<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Connection;

use DenyWhite\ClickLink\Protocol\ClickHouseQuery;
use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;

interface ClickHouseConnectionInterface
{
    public function execute(ClickHouseQuery $query): ClickHouseResponse;

    public function dispatch(ClickHouseRequest $request): ClickHouseResponse;

    public function ping(): bool;

    public function getConfig(): ClickHouseConnectionConfig;
}