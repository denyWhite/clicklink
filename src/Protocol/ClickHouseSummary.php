<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Protocol;

class ClickHouseSummary implements \Stringable
{
    public function __construct(
        public int $readRows,
        public int $readBytes,
        public int $writtenRows,
        public int $writtenBytes,
        public int $totalRowsToRead,
        public int $resultRows,
        public int $resultBytes,
        public int $elapsedNs,
    )
    {
    }

    public function __toString(): string
    {
        return sprintf(
            'ReadRows: %d, ReadBytes: %d, WrittenRows: %d, WrittenBytes: %d, TotalRowsToRead: %d, TotalRows: %d, ResultBytes: %d, Elapsed NS: %d',
            $this->readRows,
            $this->readBytes,
            $this->writtenRows,
            $this->writtenBytes,
            $this->totalRowsToRead,
            $this->resultRows,
            $this->resultBytes,
            $this->elapsedNs
        );
    }

    public static function fromJsonString(string $string): ?self
    {
        try {
            $summaryArray = json_decode($string, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }

        return new self(
            $summaryArray['readRows'] ?? 0,
            $summaryArray['readBytes'] ?? 0,
            $summaryArray['writtenRows'] ?? 0,
            $summaryArray['writtenBytes'] ?? 0,
            $summaryArray['totalRowsToRead'] ?? 0,
            $summaryArray['resultRows'] ?? 0,
            $summaryArray['resultBytes'] ?? 0,
            $summaryArray['elapsedNs'] ?? 0
        );
    }
}