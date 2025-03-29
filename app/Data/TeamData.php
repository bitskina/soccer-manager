<?php

namespace App\Data;

use Spatie\LaravelData\Optional;

class TeamData extends AbstractLaravelData
{
    public function __construct(
        public Optional|null|string $name,
        public Optional|null|string $countryId,
    ) {}
}
