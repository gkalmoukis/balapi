<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChampionshipRequest;
use App\Http\Requests\UpdateChampionshipRequest;
use App\Http\Resources\{ChampionshipCollection, ChampionshipResource};
use App\Models\{Championship};
use App\Repositories\ChampionshipRepository;
use App\Repositories\TeamRepository;

class ChampionshipController extends Controller
{
    public function __construct(
        protected TeamRepository $teams,
        protected ChampionshipRepository $championships
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $championships = $this->championships->getAll([], request()->all());
        
        return response()->json(new ChampionshipCollection($championships));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChampionshipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChampionshipRequest $request)
    {
        $validated = $request->validated();
        
        $newChampionship = $this->championships->create($validated);

        return response()->json(new ChampionshipResource($newChampionship));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $championship = $this->championships->getById($id);

        $participatingTeams = $this->championships->getParticipantingTeams($championship->id);

        $championship->teams =  $this->teams->getChampionshipLeaderboard($id, $participatingTeams);
        
        return response()->json(new ChampionshipResource($championship));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChampionshipRequest  $request
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChampionshipRequest $request, $id)
    {
        $validated = $request->validated();

        $this->championships->update($id, $validated);

        $modifiedChampionship = $this->championships->getById($id); 

        return response()->json(new ChampionshipResource($modifiedChampionship));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChampionshipRequest  $request
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $this->championships->close($id);

        $modifiedChampionship = $this->championships->getById($id); 

        return response()->json(new ChampionshipResource($modifiedChampionship));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->championships->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage() 
            ]);
        }

        return response()->json([
            "message" => "Championship {$id} deleted" 
        ]);
    }
}
