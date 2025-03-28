<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessLogicException;
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

    /**
     * @throws \App\Exceptions\BusinessLogicException
     */
    public function update(UpdateTeamRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (blank($user->team)) {
            throw new BusinessLogicException(__('exception.team_not_found'));
        }

        $this->teamService->update($user->team, $request->validated());

        return response()->success();
    }
}
