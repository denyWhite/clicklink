<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Support;

use DenyWhite\ClickLink\Protocol\FormatEnum;

interface InterpolateQueryInterface
{
    /**
     * @param string $query
     * @param array<string, string|int|float|bool|list<string|int|float|bool>> $bindings
     * @param FormatEnum $format
     * @return string
     */
    public function interpolate(string $query, array $bindings, FormatEnum $format): string;
}