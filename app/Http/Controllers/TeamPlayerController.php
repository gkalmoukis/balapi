<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamPlayerRequest;
use App\Http\Requests\UpdateTeamPlayerRequest;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;

class TeamPlayerController extends Controller
{
    public function store(StoreTeamPlayerRequest $request, $id)
    {
        $validated = $request->validated();

        $team = Team::with('players')->findOrFail($id);

        $team->players()->attach($validated);

        return response()->json(new TeamResource($team));

    }

    public function destroy($teamId, $playerId)
    {
        $team = Team::with('players')->findOrFail($teamId);

        if(!$team->players()->detach($playerId)){
            return response()->json("Oops, Player {$playerId} was not found in team {$teamId}", 404);
        }

        return response()->json("Player {$playerId} detached from team {$teamId}");

        
    }
}
