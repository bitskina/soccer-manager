<?php

namespace App\Services;

use App\Jobs\GenerateUserTeam;
use App\Models\User;

class UserService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): void
    {
        $user = User::create($data);

        GenerateUserTeam::dispatch($user);
    }
}
