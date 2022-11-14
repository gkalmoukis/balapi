<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChampionshipRequest;
use App\Http\Requests\UpdateChampionshipRequest;
use App\Http\Resources\{ChampionshipCollection, ChampionshipResource};
use App\Models\Championship;


class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(new ChampionshipCollection(Championship::all()));
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
