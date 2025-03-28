<?php

namespace App\Traits;

trait EnumListTrait
{
    /**
     * @return array<int, string|int>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
