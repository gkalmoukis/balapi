<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChampionshipRequest;
use App\Http\Requests\UpdateChampionshipRequest;
use App\Http\Resources\{ChampionshipCollection, ChampionshipResource, TeamCollection};
use App\Models\{Championship, Team};
use Carbon\Carbon;

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $championships = Championship::all();

        if(request()->filled('status')){
            
            if(request()->input('status') == 'open'){
                $championships = Championship::open()->get();
            }

            if(request()->input('status') == 'finished'){
                $championships = Championship::finished()->get();
            }
        }

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
        
        $newChampionship = Championship::create($validated);

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
        $championship = Championship::with('games')->findOrFail($id);
        
        $participatingATeams = $championship->games->map(function ($game){
            
            return $game->team_a_id;
        });
       
        $participatingBTeams = $championship->games->map(function ($game){
            return $game->team_b_id;
        });

        $teams = Team::with('players')
            ->with('results')
            ->withSum(['results' => function ($query) use ($id){
                $query->championship($id);
            }], 'points')
            ->orderBy('results_sum_points', 'desc')
            ->whereIn('id', array_merge($participatingATeams->unique()->toArray(), $participatingBTeams->unique()->toArray()))
            ->get();

        $championship->teams =  $teams;
       
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

        $championship = Championship::findOrFail($id);

        $championship->update($validated);

        $modifiedChampionship = Championship::findOrFail($id); 

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
        $championship = Championship::findOrFail($id);

        $championship->update([
            "finished_at" => \Carbon\Carbon::now()
        ]);

        $modifiedChampionship = Championship::findOrFail($id); 

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
        $championship = Championship::findOrFail($id);
    
        $championship->delete();

        return response()->json([
            "message" => "Championship {$id} deleted" 
        ]);
    }
}
