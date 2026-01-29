<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Protocol;

final readonly class ClickHouseResponse
{
    public function __construct(
        public string             $rawBody,
        public array              $headers,
        public FormatEnum         $format,
        public ?ClickHouseSummary $summary = null,
    )
    {
    }

    public function isEmpty(): bool
    {
        return $this->rawBody === '';
    }

    public function json(): array
    {
        if (!in_array($this->format, [FormatEnum::JSON, FormatEnum::JSONCompact], true)) {
            return [];
        }
        try {
            return json_decode($this->rawBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return [];
        }
    }
}