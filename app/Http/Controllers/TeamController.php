<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Http\Resources\Teams\TeamResource;
use App\Models\User;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function __construct(private readonly TeamService $teamService) {}

    public function show(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        return response()->success([
            'team' => TeamResource::make($this->teamService->getUserTeam($user)),
        ]);
    }

    public function update(UpdateTeamRequest $request): JsonResponse
    {
        /** @var \App\Models\Team $team */
        $team = Auth::user()?->team;

        $this->teamService->update($team, $request->validated());

        return response()->success();
    }
}
