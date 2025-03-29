<?php

namespace App\Http\Controllers;

use App\Http\Requests\Players\UpdatePlayerRequest;
use App\Http\Resources\Players\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PlayerController extends Controller
{
    public function __construct(private readonly PlayerService $playerService) {}

    public function index(): AnonymousResourceCollection
    {
        /** @var \App\Models\Team $team */
        $team = Auth::user()?->team;

        return PlayerResource::collection($this->playerService->getTeamPlayers($team));
    }

    public function update(UpdatePlayerRequest $request, Player $player): JsonResponse
    {
        Gate::authorize('update-player', $player);

        $this->playerService->update($player, $request->validated());

        return response()->success();
    }
}
