<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Protocol;

use DenyWhite\ClickLink\Support\DefaultInterpolateQueryService;
use DenyWhite\ClickLink\Support\InterpolateQueryInterface;

class ClickHouseQuery implements \Stringable
{
    private ?string $interpolatedQuery = null;

    private ?InterpolateQueryInterface $interpolateQueryService = null;

    public function __construct(
        private readonly string     $query,
        private readonly array      $bindings = [],
        private readonly FormatEnum $format = FormatEnum::JSONCompact,
    )
    {

    }

    public function setInterpolateService(InterpolateQueryInterface $interpolateQueryService): void
    {
        $this->interpolateQueryService = $interpolateQueryService;
    }

    private function getInterpolateService(): InterpolateQueryInterface
    {
        return $this->interpolateQueryService ?? new DefaultInterpolateQueryService();
    }

    public function getQuery(): string
    {
        return $this->interpolatedQuery ??= $this->buildQuery();
    }

    public function getFormat(): FormatEnum
    {
        return $this->format;
    }

    private function buildQuery(): string
    {
        return $this->getInterpolateService()->interpolate($this->query, $this->bindings, $this->format);
    }


    public function __toString()
    {
        return $this->getQuery();
    }
}