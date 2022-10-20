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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamPlayerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamPlayerRequest $request, $id)
    {
        $validated = $request->validated();

        $team = Team::with('players')->findOrFail($id);

        $team->players()->attach($validated);

        return response()->json(new TeamResource($team));

    }
}
