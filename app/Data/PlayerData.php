<?php

namespace App\Data;

use Spatie\LaravelData\Optional;

class PlayerData extends AbstractLaravelData
{
    public function __construct(
        public Optional|null|string $firstName,
        public Optional|null|string $lastName,
        public Optional|null|int $countryId,
    ) {}
}
