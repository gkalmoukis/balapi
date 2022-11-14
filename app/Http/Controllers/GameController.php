<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Http\Resources\{GameCollection, GameResource};

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(new GameCollection(Game::with('teamA.players', 'teamB.players')->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $validated = $request->validated();
        
        try {
            $newGame = Game::create($validated);
        
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 400);
        }
        

        return response()->json(new GameResource($newGame));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);

        return response()->json(new GameResource($game));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGameRequest  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, $id)
    {
        $validated = $request->validated();

        $game = Game::findOrFail($id);

        try {
            $game->update($validated);
        
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 400);
        }

        $modifiedGame = Game::findOrFail($id); 

        return response()->json(new GameResource($modifiedGame));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
    
        $game->delete();

        return response()->json([
            "message" => "Game {$id} deleted" 
        ]);
    }
}
