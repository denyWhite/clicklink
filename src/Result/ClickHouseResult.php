<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Result;

use Traversable;

final readonly class ClickHouseResult implements \IteratorAggregate, \Countable
{
    /**
     * @param list<array<string, mixed>> $rows
     */
    public function __construct(
        private array  $rows,
        private ?float $elapsed = null,
        private ?int   $rowsRead = null,
        private ?int   $bytesRead = null,
    )
    {

    }

    public function rows(): array
    {
        return $this->rows;
    }

    /** @inheritdoc */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->rows);
    }

    /** @inheritdoc */
    public function count(): int
    {
        return \count($this->rows);
    }


    public function iterateAs(string $dtoClass): \Traversable
    {
        foreach ($this->rows as $row) {
            yield new $dtoClass(...$row);
        }
    }

    public function mapTo(string $dtoClass): array
    {
        return iterator_to_array($this->iterateAs($dtoClass));
    }

    public function getElapsed(): ?float
    {
        return $this->elapsed;
    }

    public function getRowsRead(): ?int
    {
        return $this->rowsRead;
    }

    public function getBytesRead(): ?int
    {
        return $this->bytesRead;
    }
}