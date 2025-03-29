<?php

namespace App\Http\Controllers;

use App\Contracts\PlayerTransferContract;
use App\Http\Requests\PlayerTransfers\StorePlayerTransferRequest;
use App\Http\Resources\PlayerTransfers\PlayerTransferResource;
use App\Models\PlayerTransfer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PlayerTransferController extends Controller
{
    public function __construct(private readonly PlayerTransferContract $playerTransferService) {}

    public function index(): AnonymousResourceCollection
    {
        return PlayerTransferResource::collection($this->playerTransferService->paginate());
    }

    public function store(StorePlayerTransferRequest $request): JsonResponse
    {
        $this->playerTransferService->store($request->validated());

        return response()->success();
    }

    public function buy(PlayerTransfer $playerTransfer): JsonResponse
    {
        /** @var \App\Models\Team $team */
        $team = Auth::user()?->team;

        $this->playerTransferService->buy($team, $playerTransfer);

        return response()->success();
    }
}
