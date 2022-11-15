<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\{TeamResource, TeamCollection};
use App\Repositories\TeamRepository;

class TeamController extends Controller
{
    public function __construct(
        protected TeamRepository $teams
    ) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            new TeamCollection(
                $this->teams->getAll()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $validated = $request->validated();
        
        $newTeam = $this->teams->create($validated);

        return response()->json(new TeamResource($newTeam));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team =  $this->teams->getById($id, ['players']);

        return response()->json(new TeamResource($team));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, $id)
    {
        $validated = $request->validated();

        $this->teams->update($id, $validated);

        $modifiedTeam = $this->teams->getById($id); 

        return response()->json(new TeamResource($modifiedTeam));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->teams->delete($id);

        return response()->json([
            "message" => "Team {$id} deleted" 
        ]);
    }
}
