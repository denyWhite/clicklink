<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Result\Parser;

use DenyWhite\ClickLink\Protocol\ClickHouseResponse;
use DenyWhite\ClickLink\Result\ClickHouseResult;

class ClickHouseResultParser
{
    public function parse(ClickHouseResponse $response): ClickHouseResult
    {
        $result = $response->json();
        $elapsed = $result['statistics']['elapsed'] ?? null;
        $rowsRead = $result['statistics']['rows_read'] ?? null;
        $bytesRead = $result['statistics']['bytes_read'] ?? null;

        $countCols = count($result['meta'] ?? []);

        if ($countCols === 0) {
            return new ClickHouseResult([], $elapsed, $rowsRead, $bytesRead);
        }

        $rows = [];
        foreach ($result['data'] ?? [] as $row) {
            $addingRow = [];
            foreach ($row as $key => $value) {
                $addingRow[$result['meta'][$key]['name']] = $this->getTypedValue($result['meta'][$key]['type'], $value);
            }
            $rows[] = $addingRow;
        }

        return new ClickHouseResult($rows, $elapsed, $rowsRead, $bytesRead);
    }

    private function getTypedValue(string $type, mixed $value): int|string
    {
        return match ($type) {
            'UInt32' => (int)$value,
            default => (string)$value,
        };
    }
}