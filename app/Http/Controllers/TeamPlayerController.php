<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamPlayerRequest;
use App\Models\Team;
use App\Repositories\TeamRepository;
use App\Http\Resources\TeamResource;

class TeamPlayerController extends Controller
{
    public function __construct(
        protected TeamRepository $teams
    ) {}

    public function store(StoreTeamPlayerRequest $request, $id)
    {
        $validated = $request->validated();

        $this->teams->attachPlayer($id, $validated);

        $team = $this->teams->getById($id, ['players']);

        return response()->json(new TeamResource($team));

    }

    public function destroy($teamId, $playerId)
    {
        if(!$this->teams->detachPlayer($teamId, $playerId)){
            return response()->json("Oops, Player {$playerId} was not found in team {$teamId}", 404);
        }
        
        return response()->json("Player {$playerId} detached from team {$teamId}");
    }
}
