<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Middleware;

use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;
use Psr\Log\LoggerInterface;

readonly class LoggingMiddleware implements ClickHouseMiddlewareInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    /** @inheritdoc */
    public function handle(ClickHouseRequest $request, callable $next): ClickHouseResponse
    {
        $start = microtime(true);

        try {
            $this->logger->info('ClickHouse query start', [
                'sql' => (string)$request->query,
                'database' => $request->config->database,
            ]);

            $response = $next($request);
            $duration = round((microtime(true) - $start) * 1000, 2);

            $this->logger->info('ClickHouse query executed', [
                'sql' => (string)$request->query,
                'database' => $request->config?->database,
                'durationMs' => $duration,
                'summary' => (string)$response->summary,
            ]);

            $this->logger->debug('ClickHouse raw response', [
                'headers' => $response->headers,
                'summary' => $response->summary,
            ]);

            return $response;
        } catch (\Throwable $throwable) {
            $this->logger->error('ClickHouse query failed', [
                'sql' => (string)$request->query,
                'error' => $throwable->getMessage(),
            ]);
            throw $throwable;
        }
    }
}