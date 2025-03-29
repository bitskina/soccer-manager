<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class), MapOutputName(SnakeCaseMapper::class)]
abstract class AbstractLaravelData extends Data
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        // @phpstan-ignore-next-line
        return parent::toArray();
    }
}
