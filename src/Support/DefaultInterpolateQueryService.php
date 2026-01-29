<?php
declare(strict_types=1);

namespace DenyWhite\ClickLink\Support;

use DenyWhite\ClickLink\Protocol\FormatEnum;

class DefaultInterpolateQueryService implements InterpolateQueryInterface
{
    /** @inheritdoc
     * @param string $query
     * @param array $bindings
     * @param FormatEnum $format
     */
    public function interpolate(string $query, array $bindings, FormatEnum $format): string
    {
        return sprintf('%s FORMAT %s', $query, $format->value);
    }
}