<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamPlayerRequest;
use App\Http\Requests\UpdateTeamPlayerRequest;
use App\Models\TeamPlayer;

class TeamPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamPlayerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamPlayerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeamPlayer  $teamPlayer
     * @return \Illuminate\Http\Response
     */
    public function show(TeamPlayer $teamPlayer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamPlayerRequest  $request
     * @param  \App\Models\TeamPlayer  $teamPlayer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamPlayerRequest $request, TeamPlayer $teamPlayer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeamPlayer  $teamPlayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamPlayer $teamPlayer)
    {
        //
    }
}
