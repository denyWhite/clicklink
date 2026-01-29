<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Transport\Guzzle;

use DenyWhite\ClickLink\Connection\ClickHouseConnectionConfig;
use DenyWhite\ClickLink\Protocol\ClickHouseRequest;
use DenyWhite\ClickLink\Protocol\ClickHouseResponse;
use DenyWhite\ClickLink\Protocol\ClickHouseSummary;
use DenyWhite\ClickLink\Protocol\FormatEnum;
use DenyWhite\ClickLink\Transport\ClickHouseTransportInterface;
use DenyWhite\ClickLink\Transport\Exception\ClickHouseTransportException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleTransport implements ClickHouseTransportInterface
{
    public function __construct(
        private ?ClientInterface $client = null
    )
    {
        $this->client = $client ?? new Client([
            'http_errors' => false,
            'timeout' => 1,
        ]);
    }

    /** @inheritdoc */
    public function send(ClickHouseRequest $request): ClickHouseResponse
    {
        $url = $this->buildEndpoint($request->config);

        $guzzleOptions = [
            'headers' => $this->buildHeaders($request),
            'body' => $request->query->getQuery(),
        ];

        try {
            $response = $this->client->request('POST', $url, $guzzleOptions);
        } catch (GuzzleException $guzzleException) {
            throw new ClickHouseTransportException(
                sprintf('Transport error: %s', $guzzleException->getMessage()),
                previous: $guzzleException
            );
        }

        return $this->buildResponse($response, $request->query->getFormat());
    }

    private function buildEndpoint(ClickHouseConnectionConfig $config): string
    {
        $protocol = $config->isSecure ? 'https' : 'http';
        return rtrim(sprintf('%s://%s:%d/?database=%s', $protocol, $config->host, $config->port, $config->database), '/');
    }

    private function buildHeaders(ClickHouseRequest $request): array
    {
        $headers = [
            'User-Agent' => 'ClickHouseGuzzleTransport/1.0',
            'X-ClickHouse-User' => $request->config->username,
            'X-ClickHouse-Key' => $request->config->password,
        ];

        if (in_array($request->query->getFormat(), [FormatEnum::JSONCompact, FormatEnum::JSON], true)) {
            $headers['Content-Type'] = 'application/json';
        }

        if ($request->config->useCompression) {
            $headers['Accept-Encoding'] = 'gzip';
        }

        return $headers;
    }

    private function buildResponse(ResponseInterface $response, FormatEnum $format): ClickHouseResponse
    {
        $statusCode = $response->getStatusCode();
        $body = (string)$response->getBody();

        if ($statusCode !== 200) {
            throw new ClickHouseTransportException(
                sprintf('ClickHouse returned status %d: %s', $statusCode, $body)
            );
        }

        $summaryHeader = $response->getHeader('X-ClickHouse-Summary');
        $summary = (string)array_pop($summaryHeader);

        return new ClickHouseResponse($body, $response->getHeaders(), $format, ClickHouseSummary::fromJsonString($summary));
    }
}