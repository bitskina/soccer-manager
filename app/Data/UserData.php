<?php

namespace App\Data;

class UserData extends AbstractLaravelData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
