<?php

namespace App\Services;

use App\Data\UserData;
use App\Jobs\GenerateUserTeam;
use App\Models\User;

class UserService
{
    public function store(UserData $data): void
    {
        $user = User::create($data->toArray());

        GenerateUserTeam::dispatch($user);
    }
}
